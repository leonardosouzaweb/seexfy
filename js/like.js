class EmojiAnimate {
  constructor() {
    this.emojis = document.querySelectorAll(".reaction-btn");
    // Cria um container para animações se não existir
    this.container = document.querySelector(".emoji-container");
    if (!this.container) {
      this.container = document.createElement('div');
      this.container.className = 'emoji-container';
      this.container.style.position = 'fixed';
      this.container.style.left = 0;
      this.container.style.top = 0;
      this.container.style.width = '100vw';
      this.container.style.height = '100vh';
      this.container.style.pointerEvents = 'none';
      this.container.style.overflow = 'visible';
      this.container.style.zIndex = '9999';
      document.body.appendChild(this.container);
    }
    this.handleEmojiClick = this.handleEmojiClick.bind(this);
    this.addEventListeners();
  }

  addEventListeners() {
    this.emojis.forEach(emoji =>
      emoji.addEventListener("click", this.handleEmojiClick)
    );
  }

  handleEmojiClick(e) {
    const emojiSpan = e.currentTarget.querySelector('.emoji');
    if (!emojiSpan) return;

    const emojiEl = document.createElement("div");
    emojiEl.classList.add("emoji-animate");
    emojiEl.style.position = 'fixed';
    emojiEl.style.left = '0';
    emojiEl.style.top = '0';
    emojiEl.style.fontSize = '24px';
    emojiEl.style.willChange = 'transform, opacity';
    emojiEl.innerHTML = emojiSpan.innerHTML;

    this.container.appendChild(emojiEl);

    const { left, top, width, height } = emojiSpan.getBoundingClientRect();

    // Ponto final da animação - vamos animar para o topo centro da tela (ajuste se quiser)
    const endX = window.innerWidth / 2 - width / 2;
    const endY = 50; // 50px do topo da viewport

    // Define posição inicial do emoji animado
    emojiEl.style.transform = `translate(${left}px, ${top}px)`;

    // Animar do ponto inicial para o topo-centro
    const animation = emojiEl.animate(
      [
        { opacity: 1, transform: `translate(${left}px, ${top}px) scale(1)` },
        { opacity: 0, transform: `translate(${endX}px, ${endY}px) scale(2)` }
      ],
      {
        duration: 2000,
        easing: "cubic-bezier(.60,.48,.44,.86)"
      }
    );

    animation.onfinish = () => emojiEl.remove();
  }
}

new EmojiAnimate();
