//////////////////////// START: TABLE OF CONTENT ////////////////////////
var list = document.querySelector('.docs-nav');

// Select all h2 tags within the docs-content class
var headers = document.querySelectorAll('.docs-content h2');
function generateIdFromTitle(title) {
    return title
        .toLowerCase()               // Convert to lowercase
        .trim()                      // Remove leading and trailing whitespace
        .replace(/[^\w\s-]/g, '')    // Remove all non-word characters (except spaces and hyphens)
        .replace(/\s+/g, '-')        // Replace spaces with hyphens
        .replace(/-+/g, '-');        // Replace multiple hyphens with a single hyphen
}
headers.forEach(function(header, index) {
    // Get the title attribute of the h2 tag, if available
    var title = header.getAttribute('title') || header.textContent;
    // Generate a unique ID for the h2 tag if it doesn't already have one
    if (!header.id) {
        header.id = generateIdFromTitle(title)
    }

    // Create a new list item for the h2 tag
    var listItem = document.createElement('li');

    // Create a new anchor element for the h2 tag
    var anchor = document.createElement('a');
    anchor.href = '#' + header.id;
    anchor.textContent = title;

    // Append the anchor to the list item
    listItem.appendChild(anchor);
    list.appendChild(listItem);
});
const galleries = {};
function changeSlide(n, galleryId) {
  showSlides(galleries[galleryId] += n, galleryId);
}

function currentSlide(n, galleryId) {
  showSlides(galleries[galleryId] = n, galleryId);
}

function showSlides(n, galleryId) {
  let i;
  const container = document.getElementById(galleryId);
  const slides = container.getElementsByClassName("slides");
  // const thumbnails = container.getElementsByClassName("thumbnail");

  if (!galleries[galleryId]) galleries[galleryId] = 1;
  if (n > slides.length) galleries[galleryId] = 1;
  if (n < 1) galleries[galleryId] = slides.length;

  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  slides[galleries[galleryId] - 1].style.display = "block";
}
// PHOTO GALLERY
const slideContainers = document.querySelectorAll('.slide-container');
// Loop through the selected divs and log their ids
slideContainers.forEach(div => {
  galleries[div.id]=1;
});
const galleryIds = Object.keys(galleries);
for (let id of galleryIds) {
// console.log(id);
  showSlides(galleries[id], id);
}
