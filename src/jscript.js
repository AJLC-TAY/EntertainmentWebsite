const APIController = (function () {
    window.onload = loadClientAPI;
    // YOUTUBE REQUIREMENTS
    const YT_API_KEY = 'AIzaSyBmbwKSePliPBSyHyeA6BRuoxgfLES4YeQ';
    const YT_CLIENT_ID = '471584331255-p66pq86kuef1ocv3jcectp3t9kb1f9bl.apps.googleusercontent.com';
    const BIGHIT_CHANNELID = 'UC3IZKseVpdzPSBaWxBxundA';

    // SPOTIFY REQUIREMENTS
    const SP_CLIENT_ID = '42aee398a9a943fd839ff19072e88470';
    const SP_CLIENT_SEC = 'ce15cd96b46444929eec7b641dea0365';
    const SP_TOKEN = btoa(SP_CLIENT_ID + ":" + SP_CLIENT_SEC);

    // No of elements
    const MAX_RESULTS = '10';

    /** Private methods for Youtube API */

    //loads the Youtube API
    function loadClientAPI() {
        gapi.client.setApiKey(YT_API_KEY);
        gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
            .then(function() { console.log("GAPI client loaded for API"); },
                function(err) { console.error("Error loading GAPI client for API", err); });
        gapi.client.init({'clientId': YT_CLIENT_ID});
    }

    // gets the artists data
    const _fetchArtistData = async () => {
        const result = await fetch('http://bighitmusic.com/Artist.txt');
        console.log(result);
        return await result.json();
    }


    // fetches the videos by the explicit keyword
    const _fetchSongs = async (keyword) => {
        var response = await gapi.client.youtube.search.list({
            "part": "snippet",
            "channelId": BIGHIT_CHANNELID,
            "maxResults": MAX_RESULTS,
            "q": keyword,
            "type": "video"
        });
        return response.result.items;
    }

    /** Private methods for Spotify API */

    // Fetches the token of the Spotify API
    const _getToken = async () => {
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

    // const _getArtist = async (id, token) => {
    //     const result = await fetch(`https://api.spotify.com/v1/${id}`, {
    //         method: 'GET',
    //         headers: { 'Authorization' : 'Bearer ' + token}
    //     });
    //
    //     return (await result.json()).artist;
    // }

    // Fetches the Top Tracks of an artist by its ID, in a country
    const _getTopTracks = async (artistId, market) => {

        const result = await fetch (`https://api.spotify.com/v1/artists/${artistId}/top-tracks?market=${market}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type' : 'application/json',
                'Authorization' : 'Bearer ' + await _getToken(),
            }
        });

        return await result.json();
    }

    // use of closures to access the private methods
    return {

        // public method
        fetchArtistData() {
            return _fetchArtistData();
        },

        fetchSongs(keyword) {
            return _fetchSongs(keyword);
        },

        getToken() {
            return _getToken();
        },
        // getArtist(artistId, token) {
        //     return _getArtist(artistId, token);
        // },
        getTopTracks(artistId, market, token) {
            return _getTopTracks(artistId, market, token);
        }
    }

})();

const UIController = (function() {
    const DOMElements = {
        head: 'head',
        style: '#main-style',
        songList: '#song-list',
        artistList: '#artist-list',
        searchField: '#search-fld',
        searchButton: '#search-btn',
        filterButtons: '#filters',

        // spotify
        artistList02: '#list',
        topTrackList: '#top-track-list'

    }

    /** Private methods */
    const _createSongDetail = async (song) => {
        let title = song.snippet.title;
        let published = song.snippet.publishedAt;
        let videoID = song.id.videoId;
        let img = song.snippet.thumbnails.high;
        let html =
            `
                <div class="video-con">
                    <div class="song-img-con">
                        <img src="${img.url}" alt="Music video" title="${title}">
                    </div>

                    <div>
                        <h4>${title}</h4>
                        <p> Artist name: <br>
                        <small>${published}</small><br>
                        </p>
                    </div>
                </div>
                `;


        try {
            document.querySelector(DOMElements.songList).insertAdjacentHTML('beforeend', html);
        } catch (e){}
    }

    const _createArtistDetail = async (artist) => {
        let img = artist.img;
        let name = artist.name;
        let nickName = artist.nickname;
        const html =
            `
                    <div class="artistContainer">
                        <a href="https://kprofiles.com/big-hit-entertainment-profile-history-artists-facts/">
                        <img src="${img}" alt="${nickName}">
                        </a>
                        <br>
                        <p><em><strong>${name}</strong></em></p>       
                        <p>
                            Debut Year: ${artist.debutYear}<br>
                            No of Artists: ${artist.memberNo}
                        </p>
                    </div>
                    <br>
                `;

        try {
            document.querySelector(DOMElements.artistList).insertAdjacentHTML('beforeend', html);
        } catch (e) {}
    }

    const _createArtistList = async (artist) => {
        let name = artist.nickname;

        const html = `
            <button id="${name}" class="filter-but" type="button">
                <p style="margin: 2px 4px;">${name}</p>
            </button>
        `;

        try {
            document.querySelector(DOMElements.filterButtons).insertAdjacentHTML('beforeend', html);
        } catch (e) {}
    }

    const _displayNoSongResults = async () => {
        let html = `<p>No results found.</p>`;
        try {
            document.querySelector(DOMElements.songList).insertAdjacentHTML('beforeend', html);
        } catch (e) {}
    }

    const _createTopTrack = async (track) => {
        let artistName = track.album.artists[0].name;
        let trackId = track.id;
        let artistId = track.album.artists[0].id;
        let trackName = track.name;
        let albumName = track.album.name;
        let releasedate = track.album.release_date;
        let img = track.album.images[1];
        // let html = `
        //     <div class="spotify-song-con" style="display: flex; margin: 10px auto; width: 600px; height: 300px;">
        //         <img src="${img.url}" alt="Album image" style="width: ${img.width}; height: ${img.height}; margin: auto 20px" >
        //         <div style="align-items: center; display: block;">
        //             <h3>${trackName}</h3>
        //             <p>${artistName} <br>
        //                 <small>Album name: ${albumName} <br>
        //                 Released on: ${releasedate}
        //                 </small>
        //             </p>
        //         </div>
        //     </div>
        // `;


        let html = `
            <div class="spotify-song-con">
                <img src="${img.url}" alt="Album image"  >
                <div>
                    <h3>${trackName}</h3>
                    <p>${artistName} <br>
                        <small>Album name: ${albumName} <br>
                        Released on: ${releasedate}
                        </small>
                    </p>
                </div>
            </div>
        `;

        try {
            document.querySelector(DOMElements.topTrackList).insertAdjacentHTML('beforeend', html);
        } catch (e) {
            console.log('Error toptracks');
        }
    }

    const _createArtist = async (artist) => {
        const html = `<li> "${artist}" </li> `;
        document.querySelector(DOMElements.artist).insertAdjacentHTML('beforeend', html);
    }


    return {

        inputOutputFields() {
            return {
                songList: document.querySelector(DOMElements.songList),
                artistList: document.querySelector(DOMElements.artistList),
                searchField: document.querySelector(DOMElements.searchField),
                searchButton: document.querySelector(DOMElements.searchButton),
                filterButtons: document.querySelector(DOMElements.filterButtons),
                topTrackList: document.querySelector(DOMElements.topTrackList)
            }
        },

        createArtistDetail(artist) {
            return _createArtistDetail(artist);
        },

        createArtistList(artist) {
            return _createArtistList(artist);
        },

        createSongDetail(song) {
           return _createSongDetail(song);
        },

        clearSongList() {
            this.inputOutputFields().songList.innerHTML = ``;
        },

        displayNoSongsResults() {
            return _displayNoSongResults()
        },

        createArtist(artist) {
            return _createArtist(artist);
        },

        createTopTrack(track) {
            return _createTopTrack(track);
        }
        // ,
        // getStoredToken() {
        //     return {
        //         token: document.querySelector(DOMElements.hfToken).value
        //     }
        // }
    }
})();

const APPController = (function (UICtrl, APICtrl) {
    const DOMElements = UICtrl.inputOutputFields();
    const artistsDetail = Array();
    const SP_NL_RESULT = 3;

    const loadArtists = async () => {
        const artists = await APICtrl.fetchArtistData();

        console.log(artists);
       // console.log(artists);

        artists.forEach(artist => {
            // music page
            UICtrl.createArtistList(artist);
            // artist page
            UICtrl.createArtistDetail(artist);


            let artistDet = Object();
            artistDet.name = artist.name;
            artistDet.nickName = artist.nickname;
            artistDet.yId = artist.yt;
            artistDet.sId = artist.sp;

        });

        // const TOKEN = APICtrl.getToken();
        const TXT = '0ghlgldX5Dd6720Q3qFyQB';
        const TOP_TRACKS = (await APICtrl.getTopTracks(TXT, 'PH')).tracks;
        TOP_TRACKS.forEach(track => UICtrl.createTopTrack(track));

    }

    const filterClicked = async () => {

    }


    DOMElements.searchButton.addEventListener('click', async (e) => {
        //prevent page reset
        e.preventDefault();
        UICtrl.clearSongList();

        const keyword = DOMElements.searchField.value;
        try {
            const songs = await APICtrl.fetchSongs(keyword);
            songs.forEach(song => UICtrl.createSongDetail(song));
        } catch (e) {
            UICtrl.displayNoSongsResults();
        }

    });

    return {
        init() {
            console.log('App is starting');
            loadArtists();
        }
    }
})(UIController, APIController);

APPController.init();