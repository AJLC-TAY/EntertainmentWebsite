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

app.listen(8001, 'localhost');

app.get('/', (request, response) => {
    response.render('index');
});

app.get('/albums', (request, response) => {
    getAlbums().then(function(albums) {

        albums.forEach(album => {
            album.albumimg = "data:image;base64," + btoa(album.albumimg);
        });
        response.render('songs', {albums: albums});
    });
});

function getAlbums() {
    return  new Promise(function (resolve, reject) {
        const query = `SELECT albumid, albumimg, albumname, artists.artistname, releaseddate FROM albums JOIN artists USING(artistid)`;

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

app.get('/artist', (request, response) => {
    getArtists().then(function(artists) {
        //console.log(artists);
        artists.forEach(artist => {
            artist.artistimage = "data:image;base64," + btoa(artist.artistimage);
        });
        response.render('artists', {artists: artists});
    });
});

function getArtists() {
    return  new Promise(function (resolve, reject) {
        const query = `SELECT artistid, artistname, artistimage, debutyear, membernum FROM artists`;

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

app.get('/songs', (request, response) => {
    getTracks().then(function(tracks) {
        //console.log(tracks);
        tracks.forEach(track => {
            track.albumimg = "data:image;base64," + btoa(track.albumimg);
        });
        response.render('songs', {tracks: tracks});
    });
});

function getTracks() {
    return  new Promise(function (resolve, reject) {
        const query = `SELECT albumid, albumimg, albumname, artists.artistname, releaseddate, tracks.name AS trackname,
            tracks.trackid FROM albums JOIN artists USING(artistid) JOIN tracks USING(albumid)`;

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

// /**
//  * Controller responsible for fetching data from Spotify, Youtube
//  * and other relevant data for the making of DOM elements of the
//  * website.
//  *
//  * Author: Cutay, Alvin John L. & Del-ong, Kilrone Yance B.
//  */
// const APIController = (function () {
//     window.onload = loadClientAPI;
//     // YOUTUBE REQUIREMENTS
//     const YT_API_KEY = 'AIzaSyDGdhwvUVmISQJlo8oforHn9LmFL-wJZ7M';
//     const YT_CLIENT_ID = '471584331255-p66pq86kuef1ocv3jcectp3t9kb1f9bl.apps.googleusercontent.com';
//     const BIGHIT_CHANNELID = 'UC3IZKseVpdzPSBaWxBxundA';
//
//     // SPOTIFY REQUIREMENTS
//     const SP_CLIENT_ID = '42aee398a9a943fd839ff19072e88470';
//     const SP_CLIENT_SEC = 'ce15cd96b46444929eec7b641dea0365';
//     const SP_TOKEN = btoa(SP_CLIENT_ID + ":" + SP_CLIENT_SEC);
//
//     // No of elements
//     const MAX_RESULTS = '3';
//
//     /** Private methods for Youtube API */
//
//     /* Loads the Youtube API */
//     function loadClientAPI() {
//         gapi.client.setApiKey(YT_API_KEY);
//         gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
//             .then(function() { console.log("GAPI client loaded for API"); },
//                 function(err) { console.error("Error loading GAPI client for API", err); });
//         gapi.client.init({'clientId': YT_CLIENT_ID});
//     }
//
//     /* Gets the artists data */
//     const _fetchArtistData = async () => {
//         const result = await fetch('http://bighitmusic.com/Artist.txt', {
//             headers: {
//                 'Access-Control-Allow-Origin': '*',
//                 "Access-Control-Allow-Headers": "X-Requested-With"
//             }
//         });
//         return await result.json();
//     }
//
//     /* Fetches the videos by the explicit keyword */
//     const _fetchVideos = async (keyword) => {
//         var response = await gapi.client.youtube.search.list({
//             "part": "snippet",
//             "channelId": BIGHIT_CHANNELID,
//             "maxResults": MAX_RESULTS,
//             "q": keyword,
//             "type": "video"
//         });
//         return response.result.items;
//     }
//
//     /** Private methods for Spotify API */
//
//     /* Fetches the token of the Spotify API */
//     const _getToken = async () => {
//         const result = await fetch('https://accounts.spotify.com/api/token', {
//             method: 'POST',
//             headers: {
//                 'Content-Type' : 'application/x-www-form-urlencoded',
//                 'Authorization' : 'Basic ' + SP_TOKEN
//             },
//             body: 'grant_type=client_credentials'
//         });
//
//         const data = await result.json();
//         return data.access_token;
//     }
//
//     /* Fetches the Top Tracks of an artist by its ID, in a country */
//     const _getTopTracks = async (artistId, market) => {
//
//         const result = await fetch (`https://api.spotify.com/v1/artists/${artistId}/top-tracks?market=${market}`, {
//             method: 'GET',
//             headers: {
//                 'Accept': 'application/json',
//                 'Content-Type' : 'application/json',
//                 'Authorization' : 'Bearer ' + await _getToken()
//             }
//         });
//         return await result.json();
//     }
//
//     /* Fetches the admin.tracks related to the searched keyword */
//     const _fetchSongs = async (keyword) => {
//         let query = encodeURI(keyword);
//         const result = await fetch (`https://api.spotify.com/v1/search?q=${query}&type=track&market=PH`, {
//             method: 'GET',
//             headers: {
//                 'Accept': 'application/json',
//                 'Content-Type' : 'application/json',
//                 'Authorization' : 'Bearer ' + await _getToken(),
//             }
//         });
//         return await result.json();
//     }
//
//     // use of closures to access the private methods
//     return {
//         // public method
//         fetchArtistData() {
//             return _fetchArtistData();
//         },
//         fetchVideos(keyword) {
//             return _fetchVideos(keyword);
//         },
//         getTopTracks(artistId, market, token) {
//             return _getTopTracks(artistId, market, token);
//         },
//         fetchSongs(keyword) {
//             return _fetchSongs(keyword);
//         }
//     }
// })();
//
//
// /**
//  * Controller responsible for the creation of DOM elements.
//  * Authors: Cutay, Alvin John L. & Del-ong, Kilrone Yance B.
//  * */
// const UIController = (function() {
//     /* Constant that holds all classes and IDs of the necessary
//     elements for the making of DOM elements.*/
//     const DOMElements = {
//         head: 'head',
//         style: '#main-style',
//         videoList: '#video-list',
//         artistList: '#artist-list',
//         searchField: '#search-fld',
//         searchButton: '#search-btn',
//         filterButtons: '#filters',
//         playVideosButtons: '.video-btn',
//
//         // spotify
//         artistList02: '#list',
//         songList: '#song-list',
//         seeVideosButton: ".see-vid",
//         songRadioBtn: "#choice1",
//         videoRadioBtn: "#choice2",
//         playAlbumButtons: ".album-btn",
//
//         resultItemsCon: '#result-items-con',
//         videoCon: '.all-video-con',
//         songCon: '.all-song-con'
//     }
//
//
//     /**
//      * Returns the specified created DOM element
//      * @param element Identifier of element to create
//      * @returns {HTMLElement} Generated element
//      */
//     function createElement(element) {
//         return document.createElement(`${element}`);
//     }
//
//     /**
//      * Returns the specified created DOM element with the implicit class
//      * @param element Identifier of element to create
//      * @param eclass Class name of the element
//      * @returns {HTMLElement} Generated element
//      */
//     function createElementWithClass(element, eclass) {
//         let el = document.createElement(`${element}`);
//         el.className = eclass;
//         return el;
//     }
//
//     /**
//      * Returns the created image containing the specified attributes
//      * @param src Location of the image
//      * @param alt Alternative value of the image
//      * @param title Title of the image
//      * @returns {HTMLElement} Generated image
//      */
//     function createImage(src, alt, title) {
//         let img = createElement('img');
//         img.src = src;
//         img.alt = alt;
//         img.title = title;
//         return img;
//     }
//
//     /**
//      * Returns the created button with the specified ID, class, and inner text
//      * @param id Identification of the button
//      * @param bclass Class name of the button
//      * @param innerTxt Text displayed inside the button
//      * @returns {HTMLElement} Generated button
//      */
//     function createButton(id, bclass, innerTxt) {
//         let btn = createElementWithClass('button', bclass);
//         btn.id = id;
//         btn.innerText = innerTxt;
//         return btn;
//     }
//
//     /** Private methods */
//     /* Creates the video detail inside the Music page
//     *  Author: Del-ong, Kilrone Yance B.
//     * */
//     const _createVideoDetail = async (song) => {
//         let title = song.snippet.title;
//         let published = song.snippet.publishedAt;
//         let videoID = song.id.videoId;
//         let img = song.snippet.thumbnails.high;
//         let videoCon = createElementWithClass('div', 'video-con');
//         let videoBtn = createElementWithClass('button', 'video-btn');
//         videoBtn.id = `${videoID}`;
//         let thumbnail = createImage(`${img.url}`, 'Music Video', `${title}`);
//         let descCon = createElementWithClass('div', 'desc-con');
//         let h4 = createElement('h4');
//         h4.innerText = `${title}`;
//         let small = createElement('small');
//         small.innerText = `${published}`;
//
//         videoBtn.insertAdjacentElement('beforeend', thumbnail);
//         videoCon.insertAdjacentElement('beforeend', videoBtn);
//         descCon.insertAdjacentElement('beforeend', h4);
//         descCon.insertAdjacentElement('beforeend', small);
//         videoCon.insertAdjacentElement('beforeend', descCon);
//
//         try {
//             document.querySelector(DOMElements.videoList).insertAdjacentElement('beforeend', videoCon);
//         } catch (e){}
//     }
//
//     /*
//     * Creates the artist detail that would be seen in the Artist page
//     * Author: Cutay, Alvin John L.
//     * */
//     const _createArtistDetail = async (artist) => {
//         let img = artist.img;
//         let name = artist.name;
//         let nickName = artist.nickname;
//         let artistCon = createElementWithClass('div', 'artistContainer');
//         let link = createElement('a');
//         link.src = 'https://kprofiles.com/big-hit-entertainment-profile-history-artists-facts/';
//         link.target = '_blank';
//         let artistImage = `<img src="${img}" alt="${nickName}" title="${nickName} image">`
//         let artistName = createElement('p');
//         artistName.innerHTML = `<strong>${name}</strong>`;
//         let artistDesc = createElement('p');
//         artistDesc.innerHTML = `Debut Year: ${artist.debutYear}<br> No of Artists: ${artist.memberNo}`;
//
//         link.innerHTML = artistImage;
//         artistCon.insertAdjacentElement('beforeend', link);
//         artistCon.insertAdjacentElement('beforeend', createElement('br'));
//         artistCon.insertAdjacentElement('beforeend', artistName);
//         artistCon.insertAdjacentElement('beforeend', artistDesc);
//         try {
//             document.querySelector(DOMElements.artistList).insertAdjacentElement('beforeend', artistCon);
//         } catch (e) {}
//      }
//
//     /*
//     * Creates filter buttons
//     * Author: Cutay, Alvin John L.
//     * */
//     const _createFilterButtons = async (artist) => {
//         let name = artist.nickname;
//
//         let button = createElementWithClass('button', 'filter-but');
//         button.type = 'button';
//         button.id = `${name}`;
//         let p = createElement('p');
//         p.innerText = `${name}`;
//         p.style = "margin: 2px 4px;";
//         button.insertAdjacentElement('beforeend', p);
//
//         try {
//             document.querySelector(DOMElements.filterButtons).insertAdjacentElement('beforeend', button);
//         } catch (e) {}
//     }
//
//     /*
//    * Creates the message to inform users that no results has been found.
//    * Author: Cutay, Alvin John L.
//    * */
//     const _displayNoSongResults = async () => {
//         let html = `<p>No results found.</p>`;
//         try {
//             document.querySelector(DOMElements.videoList).insertAdjacentHTML('beforeend', html);
//         } catch (e) {}
//     }
//
//     /*
//    * Creates the song detail to be placed in the website.
//    * Author: Cutay, Alvin John L.
//    * */
//     const _createSongDetail = async (track) => {
//         let artistName = track.album.artists[0].name;
//         let albumuri = track.album.uri;
//         var trackName = track.name;
//         let albumName = track.album.name;
//         let releasedate = track.album.release_date;
//         let img = track.album.images[1];
//
//         let spotifySongCon = createElementWithClass('div', 'spotify-song-con');
//         spotifySongCon.id = `${artistName}`;
//
//         let h3 = createElement('h3');
//         h3.innerText = `${trackName}`;
//
//         let trackInfo = createElementWithClass('div', 'track-info');
//         let albumImg = createImage(`${img.url}`, "Album image", `${albumName} album image`);
//         let songDescCon = createElementWithClass('div', 'song-desc-con');
//         let p = createElement('p');
//         p.innerHTML = `${artistName}<br>
//                         <span> <small>Album name: ${albumName}
//                         <br>Released on: ${releasedate}</small> </span>`;
//         let albumBtn = createButton(`${albumuri}`, 'album-btn', 'Play album');
//         let seeVidLink = createElementWithClass('button', 'see-vid');
//         seeVidLink.id = `${trackName}`;
//         seeVidLink.innerHTML = `<u>See Music Videos</u>`;
//
//         songDescCon.insertAdjacentElement('beforeend', p);
//         songDescCon.insertAdjacentElement('beforeend', albumBtn);
//         songDescCon.insertAdjacentElement('beforeend', seeVidLink);
//
//         trackInfo.insertAdjacentElement('beforeend', albumImg);
//         trackInfo.insertAdjacentElement('beforeend', songDescCon);
//         spotifySongCon.insertAdjacentElement('beforeend', h3);
//         spotifySongCon.insertAdjacentElement('beforeend', trackInfo);
//
//         try {
//             document.querySelector(DOMElements.songList).insertAdjacentElement('beforeend', spotifySongCon);
//             //document.getElementById(`${trackName}`).onclick = async () => { await _enterTrackToSearch(trackName) };
//         } catch (e) {
//             console.log('Error toptracks');
//         }
//     }
//
//     /*
//       * Shows the embed spotify player to play the songs under the same album ID.
//       * Author: Cutay, Alvin John L.
//       * */
//     const _playAlbumEmbed = async (albumid) => {
//         document.querySelector('.spotify-player').innerHTML = ``;
//         let html = `
//             <iframe id="spot-player" src="https://open.spotify.com/embed/album/${albumid}"
//                        frameborder="0" allowtransparency="true"
//                       allow="encrypted-media"></iframe>
//         `;
//         document.querySelector('.spotify-player').insertAdjacentHTML('beforeend', html);
//     }
//
//     const _enterTrackToSearch = async (keyword) => {
//         var search = document.querySelector(DOMElements.searchField);
//         search.value = keyword;
//         await _clearVideoList();
//         return keyword;
//     }
//
//
//     /*
//       * Creates the YouTube video player that is used to play the searched videos
//       * Author: Del-ong, Kilrone Yance B.
//       * */
//     const _playVideo = async (videoid) => {
//         document.querySelector('#videoContainer').innerHTML = ``;
//         let html = `
//              <iframe id="video-player" src="https://www.youtube.com/embed/${videoid}"
//                        frameborder="0" allowtransparency="true"
//                       allow="encrypted-media"></iframe>
//         `;
//         document.querySelector('#videoContainer').insertAdjacentHTML('beforeend', html);
//     }
//
//     const _clearVideoList = async () => {
//         document.querySelector(DOMElements.videoList).innerHTML = ``;
//     }
//
//     const _clearSongList = async () => {
//         document.querySelector(DOMElements.songList).innerHTML = ``;
//     }
//
//     return {
//
//         inputOutputFields() {
//             return {
//                 songList: document.querySelector(DOMElements.videoList),
//                 artistList: document.querySelector(DOMElements.artistList),
//                 searchField: document.querySelector(DOMElements.searchField),
//                 searchButton: document.querySelector(DOMElements.searchButton),
//                 filterButtons: document.querySelector(DOMElements.filterButtons),
//                 topTrackList: document.querySelector(DOMElements.songList),
//                 searchVidList: document.querySelector(DOMElements.searchVidList),
//                 searchSongList: document.querySelector(DOMElements.searchSongList),
//                 resultItemsCon: document.querySelector(DOMElements.resultItemsCon),
//                 songRadioBtn: document.querySelector(DOMElements.songRadioBtn),
//                 videoRadioBtn: document.querySelector(DOMElements.videoRadioBtn),
//                 videoCon: document.querySelector(DOMElements.videoCon),
//                 songCon: document.querySelector(DOMElements.songCon),
//                 videoList: document.querySelector(DOMElements.videoList)
//             }
//         },
//
//         getRadioBtns() {
//           return {
//               songRadioBtn: document.querySelector(DOMElements.songRadioBtn),
//               videoRadioBtn: document.querySelector(DOMElements.videoRadioBtn)
//           }
//         },
//
//         getSeeVidButtons() {
//             return {  seeVideosButton: document.querySelectorAll(DOMElements.seeVideosButton)}
//         },
//
//         createArtistDetail(artist) {
//             return _createArtistDetail(artist);
//         },
//
//         createFilterButtons(artist) {
//             return _createFilterButtons(artist);
//         },
//
//         createVideoDetail(song) {
//            return _createVideoDetail(song);
//         },
//
//         clearSongList() {
//             return _clearSongList();
//         },
//
//         displayNoSongsResults() {
//             return _displayNoSongResults()
//         },
//
//         createSongDetail(track) {
//             return _createSongDetail(track);
//         },
//
//         enterTrackToSearch(keyword) {
//             return _enterTrackToSearch(keyword);
//         },
//
//         clearBody() {
//             return _clearBody();
//         },
//         clearTopTrackList() {
//             return _clearSongList();
//         },
//         getPlayAlbumBtn() {
//             return  { playAlbumButtons: document.querySelectorAll(DOMElements.playAlbumButtons) }
//         },
//         playAlbumEmbed(albumid) {
//             return _playAlbumEmbed(albumid);
//
//         },
//         getPlayVideosButtons() {
//             return {  playVideosButtons: document.querySelectorAll(DOMElements.playVideosButtons)}
//         },
//         getPlayVideo(videoid) {
//             return _playVideo(videoid);
//         },
//         clearVideoList() {
//             return _clearVideoList();
//         }
//     }
// })();
//
// /**
//  * Controller responsible for controlling both the APIController and UIController
//  * Authors: Cutay, Alvin John L., & Del-ong, Kilrone Yance B.
//  * */
// const APPController = (function (UICtrl, APICtrl) {
//     const DOMElements = UICtrl.inputOutputFields();
//     const artistsDetail = Array();
//     let topTracks = [];
//     const loadSeeMVButtons = async () => {
//         // Add event listener for every button inside the song detail container to search for its music video
//         let seeMVButtons = UICtrl.getSeeVidButtons().seeVideosButton;
//         for (const btn of seeMVButtons) {
//             btn.onclick = async () => {
//                 await clickVideoRB();
//                 await UICtrl.enterTrackToSearch(btn.id);
//                 await searchYT();
//             }
//         }
//     }
//
//     /*
//      * Gets the artist information and loads the artist names for the filter buttons
//      */
//     const loadArtists = async () => {
//         const artists = await APICtrl.fetchArtistData();
//
//         // Create all filter button
//         let allbutton = {};
//         allbutton.nickname = 'All';
//         await UICtrl.createFilterButtons(allbutton);
//
//         artists.forEach(artist => {
//
//             // Creates the filter seeMVButtons for the music page
//             UICtrl.createFilterButtons(artist);
//
//             // Creates the artist information in the artist page
//             UICtrl.createArtistDetail(artist);
//
//             let artistDet = Object();
//             artistDet.name = artist.name;
//             artistDet.nickName = artist.nickname;
//             artistDet.yId = artist.yt;
//             artistDet.sId = artist.sp;
//
//             artistsDetail.push(artistDet);
//         });
//
//         await loadTopTracks();
//         await loadSeeMVButtons();
//         await loadPlayAlbumButtons();
//
//         try {
//             let filterButtons = DOMElements.filterButtons.children;
//             for (const fbtn of filterButtons) {
//                 fbtn.onclick = async () => {
//                     const artistNickname = fbtn.id; // the id of the button is the nickname of the artist
//
//                     if (artistNickname === 'All') {
//                         // clear the songs inside the top track list
//                         await UICtrl.clearTopTrackList();
//                         topTracks.forEach(song => UICtrl.createSongDetail(song));
//                         await loadSeeMVButtons();
//                         await loadPlayAlbumButtons();
//                     } else {
//                         await UICtrl.clearTopTrackList();
//
//                         // get the spotify id of the artist, as provided by the button
//                         const artistInfo = artistsDetail.find(item => item.nickName === artistNickname);
//                         const spID = artistInfo.sId;
//
//                         // if the container id of the song detail matches the id of the button then add to the list
//                         const filtered = topTracks.filter(item => item.artists[0].id === spID);
//                         filtered.forEach(song => UICtrl.createSongDetail(song));
//                         await loadSeeMVButtons();
//                         await loadPlayAlbumButtons();
//                     }
//                 }
//             }
//         } catch (e) {
//         }
//     }
//
//     const loadPlayAlbumButtons = async () => {
//         let playAlbumButtons = UICtrl.getPlayAlbumBtn().playAlbumButtons;
//
//         for (const btn of playAlbumButtons) {
//             btn.onclick = async () => {
//                 await UICtrl.playAlbumEmbed(btn.id.substring(14));
//             }
//         }
//     }
//
//     /*
//      * Fetches the top admin.tracks of every artist from the Spotify API
//      */
//     const loadTopTracks = async () => {
//         // loading of top admin.tracks to the song list
//         for (const artist of artistsDetail) {
//             let tracks = (await APICtrl.getTopTracks(artist.sId, 'PH')).tracks;
//             topTracks = topTracks.concat(tracks);
//         }
//         topTracks.sort((a, b) => {
//             var x = a.name.toLowerCase();
//             var y = b.name.toLowerCase();
//             if (x < y) {return -1;}
//             if (x > y) {return 1;}
//             return 0;
//         });
//         topTracks.forEach(track => UICtrl.createSongDetail(track));
//         // // print the url of images for the albums
//         // let jsonStringTracks = "{";
//         // topTracks.forEach(track => {
//         //         let artistName = track.album.artists[0].name;
//         //         let albumuri = track.album.uri;
//         //         let albumid = albumuri.substr(14);
//         //         var trackName = track.name;
//         //         let albumName = track.album.name;
//         //         let releasedate = track.album.release_date;
//         //         let img = track.album.images[1].url;
//         //
//         //         let stringjson = `{"name":"${artistName}","albumid":"${albumid}","trackName":"${trackName}","albumName":"${albumName}",
//         //     "releasdate":"${releasedate}","img":"${img}"},`
//         //         jsonStringTracks += stringjson;
//         //     }
//         // );
//         // jsonStringTracks += "}";
//         // console.log(jsonStringTracks);
//     }
//
//     function clickSongRB () {
//         DOMElements.videoRadioBtn.checked = false;
//         DOMElements.songRadioBtn.checked = true;
//         DOMElements.songCon.style.display = 'block';
//         DOMElements.videoCon.style.display = 'none';
//         try {
//             document.querySelector('#spot-player').style.display = 'block';
//         } catch (e) {}
//
//         try {
//             document.querySelector('.filter-con').style.display = 'block';
//         } catch (e) {}
//     }
//
//     function clickVideoRB () {
//         DOMElements.videoRadioBtn.checked = true;
//         DOMElements.songRadioBtn.checked = false;
//         DOMElements.songCon.style.display = 'none';
//         DOMElements.videoCon.style.display = 'block';
//         try {
//             document.querySelector('#spot-player').style.display = 'none';
//         } catch (e) {}
//         try {
//             document.querySelector('.filter-con').style.display = 'none';
//         } catch (e) {
//         }
//     }
//
//     try {
//         DOMElements.songRadioBtn.addEventListener('click', () => {
//             clickSongRB();
//         });
//     } catch (e) {}
//
//
//     try {
//         DOMElements.videoRadioBtn.addEventListener('click', () => {
//            clickVideoRB();
//         });
//     } catch (e) {}
//
//     /*
//      * Even listener when the search button is clicked
//      */
//     try {
//         DOMElements.searchButton.addEventListener('click', async (e) => {
//             //prevent page reset
//             e.preventDefault();
//             if (DOMElements.songRadioBtn.checked === true) {
//                 await UICtrl.clearSongList();
//                 await searchSPTFY();
//                 await loadSeeMVButtons();
//                 await loadPlayAlbumButtons();
//             } else {
//                 await UICtrl.clearVideoList();
//                 await searchYT();
//             }
//         });
//     } catch (e) {}
//
//
//     const searchSPTFY = async  () => {
//         const keyword = DOMElements.searchField.value;
//         try {
//             const songs = (await APICtrl.fetchSongs(keyword)).tracks;
//             const songItems = songs.items;
//             console.log(songs);
//             songItems.forEach(song => {
//                 artistsDetail.forEach(artistdet => {
//                     if (song.album.artists[0].id === artistdet.sId) {
//                         UICtrl.createSongDetail(song);
//                     }
//                 })
//             });
//
//
//         } catch (e) {
//             console.log('No admin.tracks found.')
//         }
//     }
//
//
//     /*
//      * Method that gets the value of the search field then finds related videos
//      * in the channel of Big Hit using the Youtube API
//      */
//     const searchYT = async () => {
//         await UICtrl.clearSongList();
//
//         const keyword = DOMElements.searchField.value;
//         try {
//             const songs = await APICtrl.fetchVideos(keyword);
//             songs.forEach(song => UICtrl.createVideoDetail(song));
//
//             let videoButtons = UICtrl.getPlayVideosButtons().playVideosButtons;
//             for (const btn of videoButtons) {
//                 btn.onclick = async () => {
//                     await UICtrl.getPlayVideo(btn.id);
//                 }
//             }
//         } catch (e) {
//             await UICtrl.displayNoSongsResults();
//         }
//     }
//
//     return {
//         init() {
//             console.log('App is starting');
//             loadArtists();
//         }
//     }
// })(UIController, APIController);
//
// APPController.init();

/*
 * Author: Calica, Gwyneth M.
 */

/*
const navSlide = () => {
  const burger = document.querySelector('.burger');
  const nav = document.querySelector('.nav-links');
  const navLinks = document.querySelectorAll('.nav-links li');

  burger.addEventListener('click',()=>{
    //Toggle Nav
    nav.classList.toggle('nav-active');

    //Animate Links
    navLinks.forEach((link, index) => {
      if (link.style.animation) {
        link.style.animation = '';
      } else {
        link.style.animation = `navLinkFade .5s ease forwards ${index / 5 + .2}s`;
      }
    });

    burger.classList.toggle('toggle');
  });
}

navSlide();
// Slideshow animation
var slideIndex = 0;
try {
    showSlides();
} catch (e){}
function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 3000);
}

 */
