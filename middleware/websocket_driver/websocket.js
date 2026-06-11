const express = require("express");
const { createServer } = require("http");
const { Server } = require("socket.io");
var cors = require("cors");
const app = express();
const httpServer = createServer(app);
const io = new Server(httpServer, {
});

// get data from database

app.use(cors());
app.all("*", function (req, res, next) {
    let origin = req.headers.origin;
    res.header(
        "Access-Control-Allow-Headers",
        "Origin, X-Requested-With, Content-Type, Accept"
    );
    next();
});



io.on("connection", (socket) => {
    console.log("Connected from : " + socket.id);
    socket.on("realtime", (data) => {
        console.log(data);
        
        io.emit("realtime_sensor", data);
    });

    socket.on("selenoid", (data) => {
        console.log(data);
        
        io.emit("realtime_selenoid", data);
    });
});


httpServer.listen(3028);

// pm2 id 36
