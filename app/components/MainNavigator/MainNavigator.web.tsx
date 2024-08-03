import React from 'react';
import { View } from 'react-native';
import SideBar from '../SideBar/SideBar';
import MainHeader from '../MainHeader';
import { Slot } from 'expo-router';
import BottomTabsNavigator from '../BottomTabsNavigator/BottomTabsNavigator';

const MainNavigator: React.FC = () => {
    return (
        <View style={{ flexDirection: 'row', position: 'relative', flex: 1 }}>

            <View style={{ flex: 1 }}>
                <MainHeader />
                <View style={{ flex: 1, flexDirection: 'row' }}>
                    <SideBar />
                    <Slot />
                </View>
                <BottomTabsNavigator />
            </View>
        </View>
    );
}

export default MainNavigator;