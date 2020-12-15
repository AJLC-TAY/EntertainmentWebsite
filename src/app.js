/* Node JS modules used in our website */
const express = require('express');
const mysql = require('mysql');
const btoa = require('btoa');

const app = express();

app.use(express.static('public'));
app.set('views', `${__dirname}/view`);
app.set('view engine', 'pug');

const connection = mysql.createConnection({
    host: 'localhost', user: 'root', password: '', database: 'bighitent', port:'3308'
});
connection.connect((err) => {
    if(err) {
        console.log("Database connection failed");
    } else {
        console.log("Database connection successful")
    }
});

/* Our website listens on port 8001 with the bighitmusic.com domain */
app.listen(8001, 'bighitmusic.com');

/**
 * Redirects the user to the index page if the user entered bighitmusic.com:8001
 * @author Kilrone Yance B. Del-ong
 */
app.get('/', (request, response) => {
    response.render('index');
});

/**
 * Redirects the user to the index page if the user entered bighitmusic.com:8001/index,
 * when the user clicks home on the navigation bar, or when the user clicks the logo
 *
 * @author Kilrone Yance B. Del-ong
 */
app.get('/index', (request, response) => {
    response.render('index');
});

/**
 * Redirects the user to the songs page if the user entered bighitmusic.com:8001/songs or
 * when the user clicks music on the navigation bar.
 *
 * @author Kilrone Yance B. Del-ong
 */
app.get('/songs', (request, response) => {
    const query1 = `SELECT albumid, albumimg, albumname, artists.artistname, releaseddate, tracks.name AS trackname,
            tracks.trackid, tracks.musicfile, tracks.musicvideo FROM albums JOIN artists USING(artistid) JOIN tracks USING(albumid)`;

    const query2 = `SELECT artistid, artistname, nickname, artistimage, debutyear, membernum FROM artists WHERE artistid != 61`;
    getTracks(query1).then(function(tracks) {
        tracks.forEach(track => {
            track.albumimg = "data:image;base64," + btoa(track.albumimg);
        });
        getArtists(query2).then(function(artists) {
            response.render('songs', {tracks: tracks, artists: artists});
        });
    });
});

/**
 * Fetches the tracks from our database to be parsed on the songs page
 *
 * @author Kilrone Yance B. Del-ong
 */
function getTracks(query) {
    return  new Promise(function (resolve, reject) {

        connection.query(query, (err, result) => {
            if (err) {
                console.log('Unsuccessful');
                reject(err);
            }else {
                console.log('Successful');
                resolve(result);
            }
        });
    });
}

/**
 * Redirects the user to the music page if the user entered bighitmusic.com:8001/about or
 * when the user clicks music on the navigation bar.
 *
 * @author Leslie Joy J. Palma
 */
app.get('/albums', (request, response) => {
    var albumid = request.query.playlist;
    const query1 = `SELECT albumid, albumimg, albumname, artists.artistname, releaseddate, tracks.name AS trackname,
            tracks.trackid, tracks.musicfile, tracks.musicvideo FROM albums JOIN artists USING(artistid) JOIN tracks USING(albumid)`;
    const query2 = `SELECT artistid, artistname, nickname, artistimage, debutyear, membernum FROM artists WHERE artistid != 61`;
    getAlbums(albumid).then(function(albums) {
        getImage(albumid).then(function (albumImage) {
            albumImage.forEach(album => {
                album.albumimg = "data:image;base64," + btoa(album.albumimg);
            });
            getTracks(query1).then(function(tracks) {
                tracks.forEach(track => {
                    track.albumimg = "data:image;base64," + btoa(track.albumimg);
                });
                getArtists(query2).then(function(artists) {
                    response.render('playlist', {tracks: tracks, artists: artists, albums: albums, albumImg: albumImage});
                });
            });
        });
    });
});
/**
 * Fetches the albums from our database to be parsed on the songs page
 *
 * @author Leslie Joy Palma
 */
function getAlbums(albumid) {
    return  new Promise(function (resolve, reject) {
        const query = `SELECT tracks.name AS trackname, tracks.musicfile FROM albums JOIN tracks USING(albumid) WHERE albumid = ?`;

        connection.query(query, [albumid], (err, result) => {
            if (err) {
                console.log('Unsuccessful');
                reject(err);
            }else {
                console.log('Successful');
                resolve(result);
            }
        });
    });
}

/**
 * Redirects the user to the videos page if the user click see vid on the songs page under a track
 *
 * @author Kilrone Yance B. Del-ong
 */
app.get('/videos', (request, response) => {
    var trackid = request.query.seeVid;
    getVid(trackid).then(function (tracks) {
        response.render('video', {tracks: tracks});
    });
});

/**
 * Fetches the youtube video key from our database which is embedded to an iframe to play the video
 *
 * @author Kilrone Yance B. Del-ong
 */
function getVid(trackid) {
    return  new Promise(function (resolve, reject) {
        const query = `SELECT name, musicvideo FROM tracks WHERE trackid = ?`;
        connection.query(query, [trackid], (err, result) => {
            if (err) {
                console.log('Unsuccessful');
                reject(err);
            }else {
                console.log('Successful');
                resolve(result);
            }
        });
    });
}

/**
 * Filters the tracks shown under the songs page when the user clicks a filter button
 *
 * @author Kilrone Yance B. Del-ong
 */
app.get('/filter', (request, response) => {
    var artistid = request.query.filterArtist;
    var query1 = `SELECT albumid, albumimg, albumname, artists.artistname, releaseddate, tracks.name AS trackname,
        tracks.trackid, tracks.musicfile, tracks.musicvideo FROM albums JOIN artists USING(artistid) JOIN tracks USING(albumid) WHERE artistid = ${artistid}`;
    var query2 = `SELECT artistid, artistname, nickname, artistimage, debutyear, membernum FROM artists WHERE artistid != 61`;
    getTracks(query1).then(function(tracks) {
        tracks.forEach(track => {
            track.albumimg = "data:image;base64," + btoa(track.albumimg);
        });
        getArtists(query2).then(function(artists) {
            response.render('songs', {tracks: tracks, artists: artists});
        });
    });
});

/**
 * Fetches the image of an album from the database to be used on the playlist
 *
 * @author Kilrone Yance B. Del-ong
 */
function getImage(albumid) {
    return  new Promise(function (resolve, reject) {
        const query = `SELECT albumimg, albumname FROM albums WHERE albumid = ?`;

        connection.query(query, [albumid], (err, result) => {
            if (err) {
                console.log('Unsuccessful');
                reject(err);
            }else {
                console.log('Successful');
                resolve(result);
            }
        });
    });
}

/**
 * Filters the tracks shown under the songs page based on the keyword when the user uses the search functionality
 *
 * @author Kilrone Yance B. Del-ong
 */
app.get('/search', (request, response) => {
    var keyword = request.query.searchTracks;
    const query1 = `SELECT albumid, albumimg, albumname, artists.artistname, releaseddate, tracks.name AS trackname,
        tracks.trackid, tracks.musicfile, tracks.musicvideo FROM albums JOIN artists USING(artistid) JOIN tracks USING(albumid) WHERE upper(tracks.name) LIKE '%${keyword}%'
        OR lower(tracks.name) LIKE '%${keyword}%'`;
    const query2 = `SELECT artistid, artistname, nickname, artistimage, debutyear, membernum FROM artists WHERE artistid != 61`;

    getTracks(query1).then(function(tracks) {
        tracks.forEach(track => {
            track.albumimg = "data:image;base64," + btoa(track.albumimg);
        });
        getArtists(query2).then(function(artists) {
            response.render('songs', {tracks: tracks, artists: artists});
        });
    });
});

/**
 * Redirects the user to the artist page if the user entered bighitmusic.com:8001/about or
 * when the user clicks artists on the navigation bar.
 *
 * @author Leslie Joy J. Palma
 */
app.get('/artist', (request, response) => {
    var query = `SELECT artistid, artistname, nickname, artistimage, debutyear, membernum FROM artists WHERE artistid != 61`;
    getArtists(query).then(function(artists) {
        response.render('artist', {artists: artists});
    });
});

/**
 * Fetches the artists from our database to be parsed on the artists page
 *
 * @author Leslie Joy J. Palma
 */
function getArtists(query) {
    return new Promise(function (resolve, reject) {
        connection.query(query, (err, result) => {
            if (err) {
                console.log('Unsuccessful');
                reject(err);
            }else {
                console.log('Successful');
                resolve(result);
            }
        });
    });
}

/**
 * Redirects the user to the about page if the user entered bighitmusic.com:8001/about or
 * when the user clicks about on the navigation bar.
 *
 * @author Kilrone Yance B. Del-ong
 */
app.get('/about', (request, response) => {
    response.render('about');
});
