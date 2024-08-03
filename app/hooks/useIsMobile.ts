import { useEffect, useState } from "react";
import { useWindowWidth } from "./useWindowWidth";

export const useIsMobile = () => {
  const { window } = useWindowWidth();
  const [isMobile, setIsMobile] = useState(false);

  useEffect(() => {
    setIsMobile(window.width <= 769);
  }, [window]);

  return isMobile;
};
