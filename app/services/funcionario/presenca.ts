import Config from "../../constants/Config";

export const FuncionarioPresencaService = async (userToken: any) => {
  const url = "funcionario/presenca";
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
