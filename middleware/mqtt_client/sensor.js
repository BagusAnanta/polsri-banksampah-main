const mqtt = require('mqtt');
const { Client } = require('pg');
const { io } = require("socket.io-client");
const socket = io("http://localhost:3028");

// Konfigurasi broker MQTT
const brokerUrl = 'mqtt://public.grootech.id';
const topics = [
    'bankSampah1-sensor1',
    'bankSampah1-sensor2',
    'bankSampah1-sensor3',
    'bankSampah1-sensor4'
];

const selenoidTopics = [
    'TopicCommand1',
    'TopicCommand2',
    'TopicCommand3',
    'TopicCommand4'
];

// Membuat client MQTT
const client = mqtt.connect(brokerUrl);

// Konfigurasi PostgreSQL
const pgClient = new Client({
    user: 'postgres',
    host: 'public.grootech.id',
    database: 'bank-sampah',
    password: 'Together1!',
    port: 5432,
});

// Menghubungkan ke PostgreSQL
pgClient.connect()
    .then(() => console.log('Connected to PostgreSQL database'))
    .catch(err => console.error('Failed to connect to PostgreSQL:', err));

// Event ketika berhasil terkoneksi ke broker MQTT
client.on('connect', () => {
    console.log('Connected to MQTT broker');
    client.subscribe(topics, (err) => {
        if (!err) {
            console.log(`Subscribed to topics: ${topics.join(', ')}`);
        } else {
            console.error('Failed to subscribe:', err);
        }
    });
});

socket.on('realtime_selenoid', (data) => {
  console.log('Received data:', data);
  if (data.topic && (data.status === 0 || data.status === 1)) {
    client.publish(data.topic, String(data.status), (err) => {
      if (err) {
        console.error(`Failed to publish to ${data.topic}:`, err);
      } else {
        console.log(`Published to ${data.topic}: ${data.status}`);
      }
    });
  } else {
    console.error('Data format salah:', data);
  }
});

// Event ketika menerima pesan dari topik
client.on('message', async (topic, message) => {
    try {
        const payload = message.toString().trim(); // Konversi ke string dan hapus spasi ekstra
        // console.log(`Received raw message from ${topic}:`, payload);

        // Konversi payload ke angka (jika gagal, akan menjadi NaN)
        const value = parseFloat(payload);

        if (isNaN(value)) {
            console.error(`Invalid numeric value from ${topic}:`, payload);
            return; // Hentikan jika bukan angka
        }

        const sensorName = topic; // Nama sensor dari topic MQTT

        // Simpan ke database PostgreSQL dengan timestamp WIB
        const query = `
            INSERT INTO sensor_logs (sensor_name, value, created_at, updated_at) 
            VALUES ($1, $2, CURRENT_TIMESTAMP AT TIME ZONE 'Asia/Jakarta', CURRENT_TIMESTAMP AT TIME ZONE 'Asia/Jakarta')
        `;
        await pgClient.query(query, [sensorName, value]);

        // console.log(`Data inserted: ${sensorName} - ${value}`);

        // Emit data ke WebSocket
        socket.emit('realtime', { sensor_name: sensorName, value });

    } catch (error) {
        console.error("Failed to process message:", error);
    }
});




// Event ketika koneksi terputus
client.on('disconnect', () => {
    console.log('Disconnected from MQTT broker');
});

// Event ketika terjadi error
client.on('error', (err) => {
    console.error('MQTT Error:', err);
});

// Menutup koneksi database saat aplikasi dihentikan
process.on('exit', () => {
    console.log('Closing database connection...');
    pgClient.end();
});
