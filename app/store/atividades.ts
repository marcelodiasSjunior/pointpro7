import AsyncStorage from "@react-native-async-storage/async-storage";
import { create } from "zustand";
import { persist, createJSONStorage } from "zustand/middleware";
import { FuncionarioAtividadesService } from "../services/funcionario/atividades";

export const useAtividadesStore = create(
  persist(
    (set) => ({
      data: null,
      loading: false,
      loadData: async () => {
        set({ loading: true });
        const userToken = await AsyncStorage.getItem("userToken");
        await FuncionarioAtividadesService(userToken)
          .catch((err) => {
            set({ data: null, loading: false });
          })
          .then((data) => {
            set({ data, loading: false });
          });
      },
    }),
    {
      name: "atividades-storage", // name of the item in the storage (must be unique)
      storage: createJSONStorage(() => AsyncStorage), // (optional) by default, 'localStorage' is used
    }
  )
);
