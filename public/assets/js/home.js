// document.addEventListener('DOMContentLoaded', function() {
//     const sliders = document.querySelectorAll('.main-slider');
//     sliders.forEach(slider => {
//         const list = slider.querySelector('.list');
//         const prevBtn = slider.querySelector('.prev-btn');
//         const nextBtn = slider.querySelector('.next-btn');
//         let scrollPosition = 0;
//         const checkScroll = () => {
//             if (list.scrollWidth > list.clientWidth) {
//                 nextBtn.style.display = 'block';
//             } else {
//                 nextBtn.style.display = 'none';
//             }
//         };
//         prevBtn.addEventListener('click', () => {
//             scrollPosition -= 200;
//             if (scrollPosition < 0) {
//                 scrollPosition = 0;
//             }
//             list.style.transform = `translateX(-${scrollPosition}px)`;
//             nextBtn.style.display = 'block';
//             prevBtn.style.display = scrollPosition === 0 ? 'none' : 'block';
//         });
//         nextBtn.addEventListener('click', () => {
//             scrollPosition += 200;
//             const maxScroll = list.scrollWidth - list.clientWidth;
//             if (scrollPosition > maxScroll) {
//                 scrollPosition = maxScroll;
//             }
//             list.style.transform = `translateX(-${scrollPosition}px)`;
//             prevBtn.style.display = 'block';
//             nextBtn.style.display = scrollPosition === maxScroll ? 'none' : 'block';
//         });
//         checkScroll();
//     });
// });
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".follow-button").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.stopPropagation();
      const aid = this.dataset.artistId;
      const isFollowing = this.dataset.following === "true";
      const action = isFollowing ? "unfollow" : "follow";

      fetch("../public/user/follow_handler.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=${action}&aid=${aid}&uid=<?php echo $uid; ?>`,
      })
        .then((response) => {
          if (response.ok) {
            return response.text(); // Change to text() for plain text response
          } else {
            throw new Error("Something went wrong on API server!");
          }
        })
        .then((data) => {
          console.log("Response data:", data);
          alert(data); // Display the text response
          if (data.includes("successfully")) {
            // Update button text and data attribute
            this.innerText = isFollowing ? "Follow" : "✔";
            this.dataset.following = isFollowing ? "false" : "true";
          }
        })
        .catch((error) => {
          console.error(error);
        });
    });
  });
});

function drop(event) {
  event.preventDefault();
  var songId = event.dataTransfer.getData("text");
  var playlistId = event.target.id;
  console.log(songId);
  console.log(playlistId);
  fetch("../public/user/add_song_to_playlist.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
              playlist_id: playlistId,
              song_id: songId,
          }),
      })
      .then((response) => response.text())
      .then((data) => {
          console.log(data);
          alert('Song has been successfully added to the playlist.');
          //reload the page
          location.reload();

      })
      .catch((error) => {
          console.error("Error:", error);
      });
}

function drag(event) {
  event.dataTransfer.setData("text", event.target.id);
}
function loadSong(title, artist, image, filePath) {
  document.getElementById("name_song").innerHTML = `
${title} <div class="subtitle">${artist}</div>`;
  document.querySelector(".preview img").src = image;
  document.querySelector(".container-audio audio").src =
    "../public/" + filePath;
}

function loadSongsByPlaylist(pid) {
  loadSongs("playlist", pid);
}

function loadSongsByAlbum(abid) {
  loadSongs("album", abid);
}

function loadSongsByArtist(aid) {
  loadSongs("artist", aid);
}

function updateImageName() {
  var filename = document.getElementById("file_image").files[0].name;
  document.getElementById("playlist_image").value = filename;
}
document.addEventListener("click", function (event) {
  var playlistOverlay = document.getElementById("playlist-overlay");
  var playlistContainer = document.getElementById("playlist-container");

  if (
    event.target !== playlistOverlay &&
    !playlistOverlay.contains(event.target)
  ) {
    playlistOverlay.style.display = "none";
  }
});

function loadSongs(option, id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.querySelector(".menu-song ul").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "load_songs.php?option=" + option + "&id=" + id, true);
  xhttp.send();
}


  
// document.addEventListener('DOMContentLoaded', function() {
//     const sliders = document.querySelectorAll('.main-slider');
//     sliders.forEach(slider => {
//         const list = slider.querySelector('.list');
//         const prevBtn = slider.querySelector('.prev-btn');
//         const nextBtn = slider.querySelector('.next-btn');
//         let scrollPosition = 0;
//         const checkScroll = () => {
//             if (list.scrollWidth > list.clientWidth) {
//                 nextBtn.style.display = 'block';
//             } else {
//                 nextBtn.style.display = 'none';
//             }
//         };
//         prevBtn.addEventListener('click', () => {
//             scrollPosition -= 200;
//             if (scrollPosition < 0) {
//                 scrollPosition = 0;
//             }
//             list.style.transform = `translateX(-${scrollPosition}px)`;
//             nextBtn.style.display = 'block';
//             prevBtn.style.display = scrollPosition === 0 ? 'none' : 'block';
//         });
//         nextBtn.addEventListener('click', () => {
//             scrollPosition += 200;
//             const maxScroll = list.scrollWidth - list.clientWidth;
//             if (scrollPosition > maxScroll) {
//                 scrollPosition = maxScroll;
//             }
//             list.style.transform = `translateX(-${scrollPosition}px)`;
//             prevBtn.style.display = 'block';
//             nextBtn.style.display = scrollPosition === maxScroll ? 'none' : 'block';
//         });
//         checkScroll();
//     });
// });

