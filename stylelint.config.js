/** @type {import('stylelint').Config} */
export default {
  extends: [
    "@wordpress/stylelint-config/scss",
  ],
  rules: {
    "font-family-no-missing-generic-family-keyword": null,
    "no-descending-specificity": null,
    "block-no-empty": null,
    "no-duplicate-selectors": null,
    "font-family-no-duplicate-names": null,
    "selector-class-pattern": null,
    "scss/at-extend-no-missing-placeholder": null,
  }
};
