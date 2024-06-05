import { Dimensions, StyleSheet } from "react-native";
import Sizes from "../../constants/Sizes";

const windowDimensions = Dimensions.get("window");

export const styles = StyleSheet.create({
  wrapper: {
    flex: 1,
    display: "flex",
    marginTop: 14,
    position: "relative",
    zIndex: 1,
    maxHeight:
      windowDimensions.height - (Sizes.footerHeight + Sizes.headerHeight),
    overflow: "scroll",
    height: "100%",
  },
});
