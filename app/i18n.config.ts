import i18n from "i18next";
import { initReactI18next } from "react-i18next";
import { pt } from "./translations";

const resources = {
  pt: {
    translation: pt,
  },
};

i18n.use(initReactI18next).init({
  resources,
  fallbackLng: "pt",
  interpolation: {
    escapeValue: false, // not needed for react!!
  },
});

export default i18n;
