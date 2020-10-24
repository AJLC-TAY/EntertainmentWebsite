const spotifyToken = "Bearer BQAYvJfdmj19773zLp9icXBbYbu8BwzfCodj8tClES2EfPuAvBuLpZPMTEW-pYMayPBNFs_HLSh15FmezrTm6p75FAmVSAZUL5D7PQexki8glJg4ci0eAho8Jgh661Xe64NVzut0p-DK1rQ"
const TXTID = '0ghlgldX5Dd6720Q3qFyQB'




const APIController = (function () {
    const CLIENT_ID = '42aee398a9a943fd839ff19072e88470';
    const CLIENT_SEC = 'ce15cd96b46444929eec7b641dea0365';
    const token = btoa(CLIENT_ID + ":" + CLIENT_SEC);

    const _getToken = async () => {
        const result = await fetch('https://accounts.spotify.com/api/token', {
            method: 'POST',
            headers: {
                'Content-Type' : 'application/x-www-form-urlencoded',
                'Authorization' : 'Basic ' + token
            },
            body: 'grant_type=client_credentials'
        });

        const data = await result.json();
        return data.access_token;
    }

    const _getArtist = async (id, token) => {
        const result = await fetch(`https://api.spotify.com/v1/${id}`, {
            method: 'GET',
            headers: { 'Authorization' : 'Bearer ' + token}
        });

        return (await result.json()).artist;
    }

    const _getTopTracks = async (artistId, market, token) => {

        const result = await fetch (`https://api.spotify.com/v1/artists/${artistId}/top-tracks?market=${market}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type' : 'application/json',
                'Authorization' : 'Bearer ' + token,
            }
        });

        return await result.json();
    }

    return {
        getToken() {
            return _getToken();
        },
        getArtist(artistId, token) {
            return _getArtist(artistId, token);
        },
        getTopTracks(artistId, market, token) {
            return _getTopTracks(artistId, market, token);
        }
    }
})();

const UIController = (function () {
    const DOMElements = {
        artistList: '#list',
        topTrackList: '#top-track-list'
    }

    const _createTopTrack = async (track) => {
        let artistName = track.album.artists[0].name;
        let trackId = track.id;
        let artistId = track.album.artists[0].id;
        let trackName = track.name;
        let albumName = track.album.name;
        let releasedate = track.album.release_date;
        let img = track.album.images[1];
        let html = `
            <div style="display: flex; margin: 10px auto; width: 600px; height: 300px;">
                <img src="${img.url}" alt="Album image" style="width: ${img.width}; height: ${img.height}; margin: auto 20px" >
                <div style="align-items: center; display: block;">
                    <h3>${trackName}</h3>
                    <p>${artistName} <br>
                        <small>Album name: ${albumName} <br>
                        Released on: ${releasedate}
                        </small>
                    </p>
                </div>
            </div>
        `;

        document.querySelector(DOMElements.topTrackList).insertAdjacentHTML('beforeend', html);
    }

    return {
        getElements() {
            return {
                artist: document.querySelector(DOMElements.artistList),
                topTrackList: document.querySelector(DOMElements.topTrackList)
            }
        },

        createArtist(artist) {
            const html = `<li> "${artist}" </li> `;
            document.querySelector(DOMElements.artist).insertAdjacentElement('beforeend', html);
        },

        createTopTrack(track) {
          return _createTopTrack(track);
        },
        getStoredToken() {
            return {
                token: document.querySelector(DOMElements.hfToken).value
            }
        }
    }

})();

const APPController = (function(UICon, APICon) {
    const DOMElem = UICon.getElements();
    const TXT_ID = '0ghlgldX5Dd6720Q3qFyQB';
    const MARKET = 'PH';
    var token;


 DOMElem.artist.addEventListener('change', async() => {
     const token = UICon.getStoredToken().token;
     const artist = await APICon.getArtist(TXTID, token);

     UICon.createArtist(artist.name);

 });

 const loadTopTracks = async (artistId, token) => {
     const tracks = (await APICon.getTopTracks(artistId, MARKET, token)).tracks;
     tracks.forEach(track => UICon.createTopTrack(track));




 }

 const loadAPI = async  () => {
     token = APICon.getToken();
     loadTopTracks(TXT_ID, token);
 }

return {
    init() {
        console.log('App is starting');
        loadAPI();
    }
}

})(UIController, APIController);


APPController.init();

