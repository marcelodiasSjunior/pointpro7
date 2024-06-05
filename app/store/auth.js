import AsyncStorage from '@react-native-async-storage/async-storage'
import { create } from 'zustand'
import { persist, createJSONStorage } from 'zustand/middleware'
import { AuthLoginService, AuthUserService } from '../services/auth'

export const useAuthStore = create(
    persist(
        (set) => ({
            user: null,
            loading: false,
            error: null,
            loadUserData: async () => {
                set({ loading: true })
                const userToken = await AsyncStorage.getItem('userToken');
                await AuthUserService(userToken).catch((err) => {
                    set({ user: '', loading: false, error: err })
                }).then((data) => {
                    set({ user: data, loading: false })
                })
            },
            login: async (payload) => {
                set({ loading: true })
                await AuthLoginService(payload).catch((err) => {
                    set({ user: null, loading: false, error: err })
                }).then(async (data) => {
                    AsyncStorage.setItem('userToken', data.token);
                    await AuthUserService(data.token).catch((err) => {
                        set({ user: null, loading: false, error: err })
                    }).then((data) => {
                        set({ user: data, loading: false })
                    })
                })
            }
        }),
        {
            name: 'auth-storage', // name of the item in the storage (must be unique)
            storage: createJSONStorage(() => AsyncStorage), // (optional) by default, 'localStorage' is used
        }
    )
)
