import * as Device from "expo-device";
import Config from "../constants/Config";

export const AuthGetUserService = async ({
  email,
  password,
  manter_conectado,
}: any) => {
  const url = "auth/login";
  const payload = {
    email,
    password,
    manter_conectado,
    device_name: Device.manufacturer + "_" + Device.modelName,
  };
  const response = await fetch(Config.apiPrefix + url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: JSON.stringify(payload),
  });

  const responseData = await response.json();
  return responseData;
};

export const AuthLoginService = async ({
  email,
  password,
  manter_conectado,
}: any) => {
  const url = "auth/login";
  const payload = {
    email,
    password,
    manter_conectado,
    device_name: Device.manufacturer + "_" + Device.modelName,
  };
  const response = await fetch(Config.apiPrefix + url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: JSON.stringify(payload),
  });

  const responseData = await response.json();
  return responseData;
};

export const AuthUserService = async (userToken: any) => {
  const url = "auth/user";
  const options = {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Authorization: "Bearer " + userToken,
    },
  };
  const response = await fetch(Config.apiPrefix + url, options);

  const responseData = await response.json();
  return responseData;
};
