import AsyncStorage from "@react-native-async-storage/async-storage";
import Config from "../../constants/Config";
import { Buffer } from "buffer";

const recognizeFace = async (
  image_uri: string,
  image_name: string,
  image_type: string,
  api_token_for_web: string,
  direction: number,
  typeUpload: string
) => {
  const userToken = await AsyncStorage.getItem("userToken");

  const form: any = new FormData();

  if (typeUpload === "blob") {
    const buffer = Buffer.from(image_uri, "base64");

    form.append("file", buffer, { filename: "document.pdf" });
  } else {
    form.append("file", {
      uri: image_uri,
      type: image_type,
      name: image_name,
    });
  }

  form.append("api_token_for_web", api_token_for_web);
  form.append("direction", direction);

  const url = "recognizerDefault";
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "multipart/form-data",
      Authorization: "Bearer " + userToken,
    },
    body: form,
  };
  return fetch(Config.apiFacialPrefix + url, options)
    .then(async (data) => {
      const res = await data.json();
      return res;
    })
    .catch((e) => {
      throw e;
    });
};

// const validateFace = async (
//   image_uri: string,
//   image_name: string,
//   image_type: string
// ) => {
//   const form: any = new FormData();
//   form.append("file", {
//     uri: image_uri,
//     type: image_type,
//     name: image_name,
//   });
//   form.uploadFile = true;
//   return await api("validate-face-preregister", form, "POST", false, "facial");
// };

// const picture = async (
//   image_uri: string,
//   image_name: string,
//   image_type: string,
//   type: string
// ) => {
//   const form: any = new FormData();
//   form.append("type", type);
//   form.append("picture", {
//     uri: image_uri,
//     type: image_type,
//     name: image_name,
//   });
//   form.uploadFile = true;
//   return await api("upload/picture", form, "POST");
// };

// const deleteUpload = async (id: any) => {
//   return await api(`upload/${id}`, {}, "DELETE");
// };

// const get = async () => {
//   return await api("upload").then((res) => {
//     return res.data;
//   });
// };

const UploadService = {
  // get,
  // deleteUpload,
  // picture,
  // validateFace,
  recognizeFace,
};

export default UploadService;
