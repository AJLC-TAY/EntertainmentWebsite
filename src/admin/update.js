try {
    trackdetail.onsubmit = async (e) => {
        e.preventDefault();
        let form = new FormData(trackdetail);
        if (form.get("newtrack").length === 0) {
            alert('Please provide a track name');
            document.getElementById('trkname').focus();
        } else {
            let url = `addTrackDB.php`;
            fetch(url, {
                method: 'POST',
                body: new FormData(trackdetail)
            }).then(result => {
                return result.text();
            }).then(el => {
                let newTrack = JSON.parse(el);
                let trackid = newTrack.trackid;
                let trackname = newTrack.trackname;
                let albumid = newTrack.albumid;
                let filepath = newTrack.filepath;
                let tablebody = document.querySelector('tbody');
                let html = `
               <tr id='${trackid}row'>
                            <td colspan='3'>
                            <form id='${trackid}form' class='row'  method='post' enctype='multipart/form-data'>
                                <input type='hidden' name='albumid' value='${albumid}'>
                                <div class='form-group col'>
                                    <input name='trackid' type='hidden' value='${trackid}'/>
                                    <input id='${trackid}name' class='form-control' name='trackname' type='text' value='${trackname}'/>
                                </div>
                                <div class='col'>
                                    <audio controls>
                                        <source src='${filepath}' type='audio/mpeg'>
                                            Your browser does not support the audio tag.
                                    </audio>
                                </div>
                                <div class='form-group col'>
                                    <input class='form-control' name='file' accept='.mp3' type='file'/>
                                </div>
                                 <div class='track-buttons'>
                                    <button type='button' class='btn btn-danger'   onclick='deleteTrack(${trackid})' name='delete'><img src='../images/delete.png' title='Delete track'>
                                    </button>
                                    <button type='button' class='btn btn-secondary' onclick='updateTrack(${trackid})' name='update'><img src='../images/update.png' title='Update track'>
                                    </button>
                                </div>
                           </form>

                           </td>
                    </tr>`;
                tablebody.insertAdjacentHTML('afterbegin', html);
            });
        }
    }
} catch (e) {}

async function deleteAlbumFromTable(albumid) {
    let url = `deleteAlbum.php?id=${albumid}`;
    let confirmationResult = confirm("Are you sure you want to delete this album?");
    if (confirmationResult) {
        fetch(url).then();
            let rowIndex = document.getElementById(`${albumid}row`).rowIndex;
            alert(`${rowIndex}row`);
            document.getElementById('albumtable').deleteRow(rowIndex);

    }
}
async function deleteAlbum(albumid) {
    let url = `deleteAlbum.php?id=${albumid}`;
    let confirmationResult = confirm("Are you sure you want to delete this album?");
    if (confirmationResult) {
        fetch(url).then();
        window.location.href='albums.php';
    }
}

async function updateAlbum() {
    let form = new FormData(document.getElementById('albumform'));
    let albumname = form.get('name').trim();
    let releaseddate = form.get('date').trim();
    let url = "saveAlbumChanges.php";

    if (albumname.length !== 0) {
        if (releaseddate.length !== 0) {
            let confirmationResult = confirm("Are you sure you want to change this album?");
            if (confirmationResult) {
                form.set('save', 1);
                // form.append('save', 1);
                await fetch (url, {
                    method: "POST",
                    body: form
                }).then();
                window.location.href='albums.php';
            }
        } else {
            alert("Please provide the date of release.")
            document.getElementById('date').focus();
        }
    } else {
        alert("Please provide name for the album.");
        document.getElementById('name').focus();
    }
}


async function addAlbum() {
    let form = new FormData(document.getElementById('albumform'));
    let albumname = form.get('name').trim();
    let releaseddate = form.get('date').trim();
    let url = "addAlbumDB.php"
    if (albumname.length !== 0) {
        if (releaseddate.length !== 0) {
            form.append("addalbum", 1);
            fetch (url, {
                method: "POST",
                body: form
            }).then(result => {
                return result.text();
            }).then(el => {
                let albumid = JSON.parse(el).albumid;
                window.location.href= `viewTracks.php?id=${albumid}`;
            });

        } else {
            alert("Please provide the date of release.")
            document.getElementById('date').focus();
        }
    } else {
        alert("Please provide name for the album.");
        document.getElementById('name').focus();
    }

}


function test() {

    let addTrackForm = document.querySelector('.addtrack_form');
    let errormsg = document.createElement('p');
    errormsg.innerHTML= 'Please provide a track name.';
    addTrackForm.insertAdjacentElement('beforeend', errormsg);

    document.getElementById('trkname').focus();
}
async function deleteTrack(trackid) {
    let form = document.getElementById(`${trackid}form`);
    let formdata = new FormData(form);
    let url = "updateTrack.php";
    let confirmationResult = confirm("Are you sure you want to delete this track?");
    if (confirmationResult) {
        formdata.append('delete', 1);
        fetch(url, {
            method: "POST",
            body: formdata
        });
        let rowIndex = document.getElementById(`${trackid}row`).rowIndex;
        document.getElementById('trackstable').deleteRow(rowIndex);
    }
}
async function updateTrack(trackid) {
    let form = document.getElementById(`${trackid}form`);
    let formdata = new FormData(form);
    let albumid = formdata.get("albumid");
    let url = "updateTrack.php";
    if (formdata.get("trackname").trim().length === 0) {
        alert("Please provide a track name.")
        document.getElementById(`${trackid}name`).focus();
    } else {
        let confirmationResult = confirm("Are you sure you want to change this track?");
        if (confirmationResult) {
            // if (!formdata.has(update)) {
            //     formdata.append('update', 1);
            // } else {
            //     formdata.set('update', 1);
            //
            // }

            formdata.set('update', 1);

            fetch(url, {
                method: "POST",
                body: formdata
            }).then(result => {
                return result.text();
            }).then(data => {
                let filepath = JSON.parse(data).filepath;
                let song = document.getElementById(`${trackid}audio`);
                song.src = `${filepath}`;
                window.location.href = `viewTracks.php?id=${albumid}`;
            });



        }
    }
}

