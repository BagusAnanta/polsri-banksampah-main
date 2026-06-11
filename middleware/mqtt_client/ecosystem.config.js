module.exports = {
    apps: [
        {
            name: 'MLJ_MQTT_REMOTE_SUMMERCIBLE',
            script: 'remote_sumercible.js',
            error_file: '/dev/null',
            out_file: '/dev/null',
            log_file: '/dev/null',
            merge_logs: true,
        },
    ],
};