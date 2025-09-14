// Shim module to map `import $ from 'jquery'` to WordPress-provided global jQuery
// This avoids bundling a separate jQuery copy and mirrors the old Webpack externals behavior.
const jq = (typeof window !== 'undefined') ? (window.jQuery || window.$) : undefined;
export default jq;
export const jQuery = jq;
export const $ = jq;
