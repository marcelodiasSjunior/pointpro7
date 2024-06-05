import AsyncStorage from '@react-native-async-storage/async-storage'
import { create } from 'zustand'
import { persist, createJSONStorage } from 'zustand/middleware'
import { FuncionarioHomeService } from '../services/funcionario/home'

export const useHomeStore = create(
    persist(
        (set) => ({
            home: null,
            loading: false,
            loadHomeData: async () => {
                set({ loading: true })
                const userToken = await AsyncStorage.getItem('userToken');
                await FuncionarioHomeService(userToken).catch((err) => {
                    set({ home: null, loading: false })
                }).then((data) => {
                    set({ home: data, loading: false })
                })
            }
        }),
        {
            name: 'home-storage', // name of the item in the storage (must be unique)
            storage: createJSONStorage(() => AsyncStorage), // (optional) by default, 'localStorage' is used
        }
    )
)
