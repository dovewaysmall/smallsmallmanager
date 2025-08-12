// Default settings
var defaultSettings = {
  Layout: "vertical", // vertical | horizontal
  SidebarType: "full", // full | mini-sidebar
  BoxedLayout: true, // true | false
  Direction: "ltr", // ltr | rtl
  Theme: "light", // light | dark
  ColorTheme: "Blue_Theme", // Blue_Theme | Aqua_Theme | Purple_Theme | Green_Theme | Cyan_Theme | Orange_Theme
  cardBorder: false, // true | false
};

// Load settings from localStorage or use defaults
var userSettings = JSON.parse(localStorage.getItem('smallsmallThemeSettings')) || defaultSettings;

// Save settings to localStorage
function saveSettings() {
  localStorage.setItem('smallsmallThemeSettings', JSON.stringify(userSettings));
}