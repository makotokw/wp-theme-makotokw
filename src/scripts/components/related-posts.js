class RelatedPosts {
  constructor() {
    this.element = document.getElementById('jp-relatedposts');
    this.moveBeforeShare();
  }

  moveBeforeShare() {
    const shareThis = document.getElementById('shareThis');
    if (this.element && shareThis?.parentNode) {
      shareThis.parentNode.insertBefore(this.element, shareThis);
    }
  }
}

export default RelatedPosts;
