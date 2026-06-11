module.exports = {
    apps: [
        {
            name: 'MLJ_MQTT_WEBSOCKET',
            script: 'websocket.js',
            error_file: '/dev/null',
            out_file: '/dev/null',
            log_file: '/dev/null',
            merge_logs: true,
        },
    ],
};