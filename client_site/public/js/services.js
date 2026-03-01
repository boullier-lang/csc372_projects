// Created by Mathew

//Date: 2/8/26
// The purpose of this .js file is to add functionality for the services list. I personally think this makes the site more functional,
//But I'm unsure if my client will agree, so feedback will definitely be needed.

//Date: 2/28/2026
//In order to make this script work with handlebars, I had to use something called 'event delegation'. Also, changed it so that this is now services.js,
//not home_page.js.

document.addEventListener("click", (event) => {
    const header = event.target.closest(".category-header");
    if (!header) return;

    const list = header.nextElementSibling;
    const arrow = header.querySelector(".arrow");

    if (!list) return;

    // Toggle the open class (your CSS handles show/hide)
    list.classList.toggle("open");

    if (arrow) arrow.classList.toggle("rotated");
	
});