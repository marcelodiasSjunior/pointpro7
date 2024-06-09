import RoutePaths from "../constants/RoutePaths";
import { useTranslation } from "react-i18next";

export type TabItem = {
  path: string;
  name: string;
  icon: string;
};

export const useTabMenuList = () => {
  const { t } = useTranslation();

  return [
    {
      path: RoutePaths.home,
      name: t("home"),
      icon: "home",
    },
    {
      path: RoutePaths.presenca,
      name: t("presenca"),
      icon: "hand-left",
    },
    {
      path: RoutePaths.notificacoes,
      name: t("notificacoes"),
      icon: "notifications",
    },
  ];
};
