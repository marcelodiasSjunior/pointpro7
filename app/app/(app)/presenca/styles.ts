import { Dimensions, StyleSheet } from "react-native";

const { width: winWidth, height: winHeight } = Dimensions.get("window");

const cameraSize = winHeight / 3;

export const styles = StyleSheet.create({
  pageWrapper: {
    paddingHorizontal: 14,
    paddingVertical: 14,
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
