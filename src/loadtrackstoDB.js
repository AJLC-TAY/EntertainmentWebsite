const mysql = require('../node_modules/mysql');
const fetch = require('../node_modules/node-fetch');
const btoa = require('../node_modules/btoa');
// SPOTIFY REQUIREMENTS
const SP_CLIENT_ID = '42aee398a9a943fd839ff19072e88470';
const SP_CLIENT_SEC = 'ce15cd96b46444929eec7b641dea0365';
const SP_TOKEN = btoa(SP_CLIENT_ID + ":" + SP_CLIENT_SEC);


var connection = mysql.createConnection({
    host:'localhost', user:'root', password:'', database:"bighitent",port:"3308"
});
// connection.query("SET NAMES 'UTF8'", (err, result) => {});

const getToken = async () => {
    const result = await fetch('https://accounts.spotify.com/api/token', {
        method: 'POST',
        headers: {
            'Content-Type' : 'application/x-www-form-urlencoded',
            'Authorization' : 'Basic ' + SP_TOKEN
        },
        body: 'grant_type=client_credentials'
    });

    const data = await result.json();
    return data.access_token;
}

/* Fetches tracks of a specified album */
const getTracksOfAlbum = async (albumId) => {
    const result = await fetch(`https://api.spotify.com/v1/albums/${albumId}/tracks`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type' : 'application/json',
            'Authorization' : 'Bearer ' + await getToken()
        }
    });
    return await result.json();
}

var trackslist = Array();
let getSpotifyAlbumId = async () => {
    connection.query('SELECT spotifyalbumid, albumid FROM albums', (err, rows) => {
        if (err) throw err;
        rows.forEach(album => loadAlbum(album));
    });
}
 getSpotifyAlbumId();
async function loadAlbum(album){
    let albumid = album.albumid;
    let spotifyid = album.spotifyalbumid;
    let getTracks = (await getTracksOfAlbum(spotifyid));

    filterdata(getTracks.items, albumid);
    // trackslist.push(getTracks.items);
    // getTracks.forEach(track => {
    //     let trackObj = {};
    //     trackObj.albumid = albumid;
    //     trackObj.name = track.name;
    //     trackslist.push(trackObj);
    // });

}

function filterdata(album, albumid) {
    album.forEach(e => {
        let trackName = e.name;
        connection.query(`INSERT INTO tracks (tracks.name, albumid) VALUES ("${trackName}", "${albumid}")`, (err, result) => {
            if (err) throw err;
            console.log("1 record inserted");
        });
    })
}

function sendTracksToDB() {
    trackslist.forEach(e => {
        console.log(e);
    });
}
sendTracksToDB();


