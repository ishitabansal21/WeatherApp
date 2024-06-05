const buttons = document.querySelectorAll(".options .opt");
const animation = document.querySelector(".animation");

buttons.forEach((btn, i) => {
  btn.addEventListener("click", () => changeTheme(i));
});

const changeTheme = (i) => {
  animation.classList = "animation";
  switch (i) {
    case 0:
      document.body.style.background = "#fff";
      animation.classList.add("white");
      break;
    case 1:
      document.body.style.background = "#151515";
      animation.classList.add("black");
      break;
    case 2:
      document.body.style.background = "#353535";
      animation.classList.add("lightblack");
      break;
    case 3:
      document.body.style.background = "#b2ebf2";
      animation.classList.add("cyan");
      break;
  }
};
