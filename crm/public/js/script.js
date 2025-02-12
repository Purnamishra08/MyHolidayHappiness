// onscroll animation
const scrollElements = document.querySelectorAll(".js-scroll");

const elementInView = (el, dividend = 1) => {
  const elementTop = el.getBoundingClientRect().top;

  return (
    elementTop <=
    (window.innerHeight || document.documentElement.clientHeight) / dividend
  );
};

const elementOutofView = (el) => {
  const elementTop = el.getBoundingClientRect().top;

  return (
    elementTop > (window.innerHeight || document.documentElement.clientHeight)
  );
};

const displayScrollElement = (element) => {
  element.classList.add("scrolled");
};

const hideScrollElement = (element) => {
  element.classList.remove("scrolled");
};

const handleScrollAnimation = () => {
  scrollElements.forEach((el) => {
    if (elementInView(el, 1.15)) {
      displayScrollElement(el);
    } else if (elementOutofView(el)) {
      //hideScrollElement(el);
    }
  });
};

//tap to top btn
const tap_top_btn = document.querySelector(".tap-toTop");
const header = document.querySelector("header");
const header_logo = document.querySelector("header .navbar-brand img");

window.onscroll = function () {
  handleScrollAnimation();
  let posHight = document.documentElement.scrollHeight;
  let pos = window.scrollY;

  if (pos > posHight - 2000) {
    tap_top_btn.classList.add("active");
  } else {
    tap_top_btn.classList.remove("active");
  }

  //sticky header function
  if (Math.ceil(pos) > 250) {
    header.classList.add("active");
    header_logo.style.opacity = "1";
    header_logo.src = "img/logo-white.png";
  } else {
    header.classList.remove("active");
    header_logo.style.opacity = ".9";
    header_logo.src = "img/logo-white.png";
  }
};

tap_top_btn.onclick = function () {
  document.documentElement.scrollTop = 0;
};
