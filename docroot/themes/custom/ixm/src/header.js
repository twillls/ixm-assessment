(() => {
  const header = document.getElementsByTagName("header")[0];
  // On scroll, toggle sticky..
  window.addEventListener("scroll", () => {
    header.classList.toggle("sticky-lg-top", window.scrollY > 0);
  });
})();
