const APIController = (function () {
    window.onload = loadClientAPI;
    const API_KEY = 'AIzaSyBmbwKSePliPBSyHyeA6BRuoxgfLES4YeQ';
    const CLIENT_ID = '471584331255-p66pq86kuef1ocv3jcectp3t9kb1f9bl.apps.googleusercontent.com';
    const BIGHIT_CHANNELID = 'UC3IZKseVpdzPSBaWxBxundA';
    const MAX_RESULTS = '10';


    //private methods

    //loads the Youtube API
    function loadClientAPI() {
        gapi.client.setApiKey(API_KEY);
        gapi.client.load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
            .then(function() { console.log("GAPI client loaded for API"); },
                function(err) { console.error("Error loading GAPI client for API", err); });
        gapi.client.init({'clientId': CLIENT_ID});
    }

    // gets the artists data
    const _fetchArtistData = async () => {
        const result = await fetch('http://localhost/Artists.txt');
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

    // use of closures to access the private methods
    return {

        // public method
        fetchArtistData() {
            return _fetchArtistData();
        },

        fetchSongs(keyword) {
            return _fetchSongs(keyword);
        }
    }

})();

const UIController = (function() {
    const DOMElements = {
        head: 'head',
        songList: '#song-list',
        artistList: '#artist-list',
        searchField: '#search-fld',
        searchButton: '#search-btn',
        filterButtons: '#filters'
    }

    const _createSongDetail = async (song) => {
        let title = song.snippet.title;
        let published = song.snippet.publishedAt;
        let videoID = song.id.videoId;
        let img = song.snippet.thumbnails.high;
        let html =
            `
                <div class="video-con">
                    <div class="song-img-con">
                        <img src="${img.url}" id="imgContainer" alt="Music video" title="${title}" style="width: 100%; height=auto">
                    </div>

                    <div>
                        <h4>${title}</h4>
                        <p> Artist name: <br>
                        <small>${published}</small><br>
                        <i>${videoID}</i></p>
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
            <button class="filter-but" type="button">
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

    return {

        inputOutputFields() {
            return {
                songList: document.querySelector(DOMElements.songList),
                artistList: document.querySelector(DOMElements.artistList),
                searchField: document.querySelector(DOMElements.searchField),
                searchButton: document.querySelector(DOMElements.searchButton),
                filterButtons: document.querySelector(DOMElements.filterButtons)
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
        }
    }
})();


const APPController = (function (UICtrl, APICtrl) {
    const DOMElements = UICtrl.inputOutputFields();

    const loadArtists = async () => {
        const artists = await APICtrl.fetchArtistData();
        console.log(artists);

        artists.forEach(artist => {
            // music page
            UICtrl.createArtistList(artist);
            // artist page
            UICtrl.createArtistDetail(artist);
        });

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