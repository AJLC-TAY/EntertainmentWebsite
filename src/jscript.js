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
    const MAX_RESULTS = '3';

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
    const _fetchVideos = async (keyword) => {
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

        fetchVideos(keyword) {
            return _fetchVideos(keyword);
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
        topTrackList: '#top-track-list',
        seeVideosButton: ".see-vid",
        songRadioBtn: "#choice1",
        videoRadioBtn: "#choice2",

        resultItemsCon: '#result-items-con'



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
                    <img src="${img.url}" alt="Music video" title="${title}">
                   
                    <div class="desc-con">
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
        var trackName = track.name;
        let albumName = track.album.name;
        let releasedate = track.album.release_date;
        let img = track.album.images[1];

        let html = `
            <div class="spotify-song-con">
                <h3>${trackName}</h3>
                <div class="track-info" >
                     <img src="${img.url}" alt="Album image"  >
                     <div class="song-desc-con">
                     
                        <p>${artistName} <br>
                           
                            <span> <small>Album name: ${albumName} <br>
                            Released on: ${releasedate}
                            </small> </span>
                        </p>
                       <button id="${trackName}" class="see-vid">See Music Videos</button>
                    </div>
                </div>   
            </div>
        `;

        try {
            document.querySelector(DOMElements.topTrackList).insertAdjacentHTML('beforeend', html);
            //document.getElementById(`${trackName}`).onclick = async () => { await _enterTrackToSearch(trackName) };
        } catch (e) {
            console.log('Error toptracks');
        }
    }

    const _enterTrackToSearch = async (keyword) => {
        var search = document.querySelector(DOMElements.searchField);
        search.value = keyword;
        await _clearBody();
        return keyword;
    }

    const _createArtist = async (artist) => {
        const html = `<li> "${artist}" </li> `;
        document.querySelector(DOMElements.artist).insertAdjacentHTML('beforeend', html);
    }

    const _clearSongList = async () => {
        document.querySelector(DOMElements.songList).innerHTML = ``;
    }


    async function _clearBody() {
        document.querySelector(DOMElements.resultItemsCon).innerHTML = `
         <div>
              <h3>Videos</h3>
              <hr>
              <ul id="song-list"></ul>
          </div>
        `;
    }

    return {

        inputOutputFields() {
            return {
                songList: document.querySelector(DOMElements.songList),
                artistList: document.querySelector(DOMElements.artistList),
                searchField: document.querySelector(DOMElements.searchField),
                searchButton: document.querySelector(DOMElements.searchButton),
                filterButtons: document.querySelector(DOMElements.filterButtons),
                topTrackList: document.querySelector(DOMElements.topTrackList),
                searchVidList: document.querySelector(DOMElements.searchVidList),
                searchSongList: document.querySelector(DOMElements.searchSongList),
                resultItemsCon: document.querySelector(DOMElements.resultItemsCon),
                songRadioBtn: document.querySelector(DOMElements.songRadioBtn),
                videoRadioBtn: document.querySelector(DOMElements.videoRadioBtn)
            }
        },

        getRadioBtns() {
          return {
              songRadioBtn: document.querySelector(DOMElements.songRadioBtn),
              videoRadioBtn: document.querySelector(DOMElements.videoRadioBtn)
          }
        },

        getSeeVidButtons() {
            return {  seeVideosButton: document.querySelectorAll(DOMElements.seeVideosButton)}
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
            return _clearSongList();
        },

        displayNoSongsResults() {
            return _displayNoSongResults()
        },

        createArtist(artist) {
            return _createArtist(artist);
        },

        createTopTrack(track) {
            return _createTopTrack(track);
        },

        enterTrackToSearch(keyword) {
            return _enterTrackToSearch(keyword);
        },
        // ,
        // getStoredToken() {
        //     return {
        //         token: document.querySelector(DOMElements.hfToken).value
        //     }
        // }
        clearBody() {
            return _clearBody();
        }
    }
})();

const APPController = (function (UICtrl, APICtrl) {
    const DOMElements = UICtrl.inputOutputFields();
    const artistsDetail = Array();
    const SP_NL_RESULT = 3;

    const loadArtists = async () => {
        const artists = await APICtrl.fetchArtistData();

        for (const artist of artists) {
            // music page
            await UICtrl.createArtistList(artist);
            // artist page
            await UICtrl.createArtistDetail(artist);

            let artistDet = Object();
            artistDet.name = artist.name;
            artistDet.nickName = artist.nickname;
            artistDet.yId = artist.yt;
            artistDet.sId = artist.sp;

            artistsDetail.push(artistDet);
            await loadTopTracks();
        }

        let buttons = UICtrl.getSeeVidButtons().seeVideosButton;
        for (const btn of buttons) {
             btn.onclick = async () => {
                 await UICtrl.enterTrackToSearch(btn.id);
                 await searchYT();
             }
        }
    }

    const loadTopTracks = async () => {
        // loading of top tracks to the song list
        for (const artistDet of artistsDetail) {
            let topTracks =  (await APICtrl.getTopTracks(artistDet.sId, 'PH')).tracks;
            topTracks.forEach(track => UICtrl.createTopTrack(track));
        }

    }

    const checkRadioButtons = async () => {
        var songRadioBtn = DOMElements.songRadioBtn;
        if (songRadioBtn.checked) {
            return 'songs';
        } else {
            return 'videos';
        }
    }


    DOMElements.searchButton.addEventListener('click', async (e) => {
        //prevent page reset
        e.preventDefault();
        searchYT();
    });

    const searchYT = async () => {
        await UICtrl.clearSongList();

        const keyword = DOMElements.searchField.value;
        try {
            const songs = await APICtrl.fetchVideos(keyword);
            songs.forEach(song => UICtrl.createSongDetail(song));
        } catch (e) {
            UICtrl.displayNoSongsResults();
        }
    }

    return {
        init() {
            console.log('App is starting');
            loadArtists();
        }
    }
})(UIController, APIController);

APPController.init();