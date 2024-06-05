import AsyncStorage from "@react-native-async-storage/async-storage";
import Config from "../../constants/Config";

export const FuncionarioAtividadesService = async (userToken: any) => {
  const url = "funcionario/atividades";
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

export const FuncionarioAtividadesCreateService = async (
  atividade_funcionario_id: number,
  atividade_id: number
) => {
  const userToken = await AsyncStorage.getItem("userToken");
  const url = `funcionario/atividades/${atividade_funcionario_id}/criar`;
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: "Bearer " + userToken,
    },
    body: JSON.stringify({ atividade_id }),
  };
  const response = await fetch(Config.apiPrefix + url, options);

  const responseData = await response.json();
  return responseData;
};

export const FuncionarioAtividadesUpdateService = async (
  funcionario_atividade_id: number,
  atividade_id: number
) => {
  const userToken = await AsyncStorage.getItem("userToken");
  const url = `funcionario/atividades/${funcionario_atividade_id}/atualizar`;
  const options = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: "Bearer " + userToken,
    },
    body: JSON.stringify({ atividade_id }),
  };
  const response = await fetch(Config.apiPrefix + url, options);

  const responseData = await response.json();
  return responseData;
};
