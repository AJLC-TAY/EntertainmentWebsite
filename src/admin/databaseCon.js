// const $ = require('../node_modules/jQuery');
// const express = require("../node_modules/express");
// const mysql = require("../node_modules/mysql");
// const bodyParser = require("body-parser");

// var connection = mysql.createConnection({
//     host:'localhost', user:'root', password:'', database:"bighitent", port:"3308"
// });

// const app = express();
// app.use(express.static('public'));
// app.set('views', `${__dirname}/admin`);
// app.set('view engine', 'pug');
// app.listen(3308, 'localhost');
// app.use(bodyParser.urlencoded({extended: true}));
// app.use(bodyParser.json());


$(document).ready(function(){
    var date_input = $('input[name="date"]');
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    var options = {
        format: 'yyyy-mm-dd',
        container: container,
        todayHighlight: true,
        autoclose: true
    };
    date_input.datepicker(options);
});

// function updateAlbum(albumid) {
//     tracklist = document.getElementById('tracklist');
//     getAlbum(albumid).then(album => displayAlbum(album));
//     getTracksOfAlbum(albumid).then(admin.tracks => {
//        admin.tracks.forEach(track => displayTrack(track));
//     });
//
// }
//
// function displayAlbum(album) {
//     console.log(album);
// }
//
// function getTracksOfAlbum(albumid) {
//     return new Promise(function (resolve, reject) {
//         connection.query('SELECT name, albumname, artists.artistname, releaseddate FROM albums JOIN artists USING(artistid) WHERE albumid=?',
//             [albumid], function(err, result, fields) {
//                 if (err) {
//                     return reject(err);
//                 } else {
//                     resolve(result);
//                 }
//
//             });
//     });
// }
//
// function getAlbum(albumid) {
//     return new Promise(function (resolve, reject) {
//         connection.query(`SELECT admin.tracks.name, musicfile FROM admin.tracks WHERE albumid=${albumid}?`,
//             function(err, result, fields) {
//                 if (err) {
//                     return reject(err);
//                 } else {
//                     result.forEach(track => displayTrack(track));
//                 }
//             });
//     });
// }
// function displayTrack(track) {
//     trackName = track.name;
//     trackfile = track.musicfile;
//
//     tracklist
//
// }