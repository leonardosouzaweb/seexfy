class EmojiAnimate {
  constructor() {
      this.emojis = document.querySelectorAll(".emoji-list button");
      this.container = document.querySelector(".emoji-container");
      this.handleEmojiClick = this.handleEmojiClick.bind(this);
      this.addEventListeners();
  }

  addEventListeners() {
      this.emojis.forEach((emoji) =>
          emoji.addEventListener("click", this.handleEmojiClick)
      );
  }

  handleEmojiClick(e) {
      const emojiEl = document.createElement("div");
      emojiEl.classList.add("emoji-animate");

      const { innerHTML } = e.target;
      emojiEl.innerHTML = innerHTML;

      this.container.appendChild(emojiEl);

      const { left, top, height } = e.target.getBoundingClientRect();
      const image = document.querySelector(".modal-storie img");
      const { left: imageLeft, top: imageTop, width: imageWidth, height: imageHeight } = image.getBoundingClientRect();

      const centerX = imageLeft + imageWidth / 2;
      const centerY = imageTop + imageHeight / 2;

      const animation = emojiEl.animate(
          [
              { 
                  opacity: 1, 
                  transform: `translate(${left}px, ${top}px)` 
              },
              {
                  opacity: 0,
                  transform: `translate(${centerX - left}px, ${centerY - top}px)`,
              },
          ],
          {
              duration: 2000,
              easing: "cubic-bezier(.60,.48,.44,.86)",
          }
      );
      animation.onfinish = () => emojiEl.remove();
  }
}

new EmojiAnimate();
