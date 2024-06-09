import { Dimensions, StyleSheet } from "react-native";
import Sizes from "../../../constants/Sizes";

const { height: winHeight } = Dimensions.get("window");

const cameraSize = winHeight / 3;

export const styles = StyleSheet.create({
  pageWrapper: {
    paddingHorizontal: 14,
    paddingBottom: 14,
    paddingTop: Sizes.headerHeight + 14,
    flex: 1,
    width: "100%",
  },
  cameraPreview: {
    position: "relative",
    width: cameraSize,
    height: cameraSize,
    borderRadius: cameraSize,
    overflow: "hidden",
  },
  cameraWrapper: {
    width: cameraSize,
    height: cameraSize,
    justifyContent: "center",
    alignItems: "center",
    alignSelf: "center",
    borderRadius: cameraSize,
    overflow: "hidden",
  },
});
