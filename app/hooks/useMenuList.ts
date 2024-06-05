import { useTranslation } from "react-i18next";
import RoutePaths from "../constants/RoutePaths";

export type MenuItem = {
  path: string;
  name: string;
  icon: string;
};

const useMenuList = () => {
  const { t } = useTranslation();

  return [
    {
      path: RoutePaths.home,
      name: t("home"),
      icon: "bar-chart",
    },
    {
      path: RoutePaths.atividades,
      name: t("atividades"),
      icon: "list-circle",
    },
    {
      path: RoutePaths.observacoes,
      name: t("observacoes"),
      icon: "chatbubbles",
    },
    {
      path: RoutePaths.presenca,
      name: t("presenca"),
      icon: "hand-left",
    },
    {
      path: RoutePaths.frequencia,
      name: t("frequencia"),
      icon: "alarm",
    },
    {
      path: RoutePaths.perfil,
      name: t("perfil"),
      icon: "cog",
    },
    {
      path: RoutePaths.faq,
      name: t("faq"),
      icon: "information-circle",
    },
    {
      path: RoutePaths.politicaDePrivacidade,
      name: t("politicaDePrivacidade"),
      icon: "finger-print",
    },
    {
      path: RoutePaths.ajuda,
      name: t("ajuda"),
      icon: "help-buoy",
    },
    {
      path: RoutePaths.sair,
      name: t("sair"),
      icon: "exit",
    },
  ];
};

export default useMenuList;
