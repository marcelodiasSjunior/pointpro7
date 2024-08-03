import { Redirect, Slot } from 'expo-router';
import { View } from 'react-native';
import SideBar from '../../components/SideBar/SideBar';
import MainHeader from '../../components/MainHeader';
import BottomTabsNavigator from '../../components/BottomTabsNavigator/BottomTabsNavigator';
import { useAuthStore } from '../../store/auth';
import { useEffect } from 'react';
import CustomSpinner from '../../components/CustomSpinner/CustomSpinner';
import MainNavigator from '../../components/MainNavigator/MainNavigator';

export default function AppLayout() {
    const loadUserData = useAuthStore((state) => state.loadUserData);
    const user = useAuthStore((state) => state.user)

    useEffect(() => {
        loadUserData()
    }, [])

    if (user === null) {
        return <CustomSpinner show={true} />;
    }

    if (user === undefined) {
        return <Redirect href="/login" />;
    }

    return <MainNavigator />
}