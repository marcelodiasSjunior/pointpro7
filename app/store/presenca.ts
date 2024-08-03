import AsyncStorage from "@react-native-async-storage/async-storage";
import { create } from "zustand";
import { persist, createJSONStorage } from "zustand/middleware";
import { FuncionarioPresencaService } from "../services/funcionario/presenca";

export const usePresencaStore = create(
  persist(
    (set) => ({
      data: null,
      loading: false,
      loadData: async () => {
        set({ loading: true });
        const userToken = await AsyncStorage.getItem("userToken");
        await FuncionarioPresencaService(userToken)
          .catch((err) => {
            set({ data: null, loading: false });
          })
          .then((data) => {
            set({ data, loading: false });
          });
      },
    }),
    {
      name: "presenca-storage", // name of the item in the storage (must be unique)
      storage: createJSONStorage(() => AsyncStorage), // (optional) by default, 'localStorage' is used
    }
  )
);
