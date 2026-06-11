// const axios = require('axios')
// var config = require('./config/config');
const mqtt = require('mqtt');
// var db = require('./config/db');
const { io } = require("socket.io-client");
const client = mqtt.connect('mqtt://public.grootech.id:1883')
const socket = io("http://localhost:3022");

// client - side
socket.on("connect", () => {
    console.log(socket.id); // x8WIv7-mJelg7on_ALbx
});

socket.on("disconnect", () => {
    console.log(socket.id); // undefined
});


client.on('connect', async function () {
    client.subscribe('iot/mljsite2/read', function (err) {
        if (!err) {
            //   client.publish('presence', 'Hello mqtt')
        }
    })
})


// socket on
socket.on('remote_centrifugal', async function (data) {
    // console.log(data);
    client.publish('iot/mljsite2/write', JSON.stringify(data));
});



client.on('message', async function (topic, message) {
    // message is Buffer
    if (topic == 'iot/mljsite2/read') {
        var payload = message.toString();
        var payloadJSON = JSON.parse(payload);

        // REG002
        var REG002 = findObjectValue(payloadJSON.sensorDatas, 'flag', 'REG002').switcher;
        // if reg002 == 1 publis
        if (REG002 == 1) {
            // CONSOLE LOG REG002 RELEASE
            // console.log('REG002 RELEASE');
            client.publish('iot/mljsite2/write', JSON.stringify({
                "sensorDatas": [{
                    "sensorsId": "BeiLai Gateway",
                    "switcher": 0,
                    "flag": "REG002"
                }],
                "down": "down"
            }));
        }

        // REG003
        var REG003 = findObjectValue(payloadJSON.sensorDatas, 'flag', 'REG003').switcher;
        // if reg003 == 1 publis
        if (REG003 == 1) {
            // CONSOLE LOG REG003 RELEASE
            // console.log('REG003 RELEASE');
            client.publish('iot/mljsite2/write', JSON.stringify({
                "sensorDatas": [{
                    "sensorsId": "BeiLai Gateway",
                    "switcher": 0,
                    "flag": "REG003"
                }],
                "down": "down"
            }));
        }

        // console.log(payloadJSON);
    }
})



function findObjectValue(arrayObject, key, value) {
    for (var i = 2; i < arrayObject.length; i++) {
        if (arrayObject[i][key] === value) {
            return arrayObject[i];
        }
    }
    return null;
}






/*
Publish Payload
{
    "sensorDatas": [{
        "sensorsId": "BeiLai Gateway",
        "switcher": 0,
        "flag": "REG026"
    }],
    "down": "down"
}

*/
// pm2 id 35
