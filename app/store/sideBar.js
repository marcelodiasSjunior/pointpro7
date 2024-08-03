import { create } from 'zustand'

export const sideBarStore = create((set) => ({
  state: '',
  toggle: (state) => set({ state: String(Math.random()) })
}))