import { Ionicons } from '@expo/vector-icons';
import React from 'react';
import { StyleSheet, View, Image } from 'react-native';
import { sideBarStore } from '../store/sideBar';
import { TouchableOpacity } from 'react-native-gesture-handler';
import { useAuthStore } from '../store/auth';
import { useWindowWidth } from '../hooks/useWindowWidth';
import Sizes from '../constants/Sizes';
import { router } from 'expo-router';
import RoutePaths from '../constants/RoutePaths';
const userNoFoto = require('../assets/images/user-no-foto.png');
const logoImage = require('../assets/images/logo-big.png');

const MainHeader: React.FC = () => {
    const toggleSideBar = sideBarStore((state) => state.toggle)
    const user = useAuthStore((state) => state.user)
    const { window } = useWindowWidth();

    if (!user) {
        return <></>
    }

    return (
        <View style={styles.container}>
            <View style={styles.leftWrapper}>
                <View style={styles.logoWrapper}>
                    <Image
                        style={styles.logoPro7}
                        source={logoImage}
                        resizeMode="contain"
                    />
                </View>
                {
                    window.width >= 768 &&
                    <TouchableOpacity onPress={() => {
                        toggleSideBar()
                    }}>
                        <Ionicons
                            name="menu"
                            size={30}
                        />
                    </TouchableOpacity>
                }

            </View>

            <View style={{ flexDirection: 'row', alignItems: 'center' }}>
                <TouchableOpacity onPress={() => {
                    router.push(RoutePaths.perfil)
                }}><Image
                        style={styles.avatar}
                        source={user.avatar?.length > 0 ? user.avatar : userNoFoto}
                        resizeMode="contain"
                    />
                </TouchableOpacity>

                {
                    window.width < 768 &&
                    <TouchableOpacity onPress={() => {
                        toggleSideBar()
                    }}>
                        <Ionicons
                            name="menu"
                            size={30}

                        />
                    </TouchableOpacity>
                }
            </View>
        </View >
    );
}

const styles = StyleSheet.create({
    container: {
        paddingVertical: 10,
        paddingHorizontal: 10,
        flexDirection: 'row',
        alignItems: 'center',
        justifyContent: 'space-between',
        borderBottomWidth: 0.5,
        borderBottomColor: '#ccc',
        height: Sizes.headerHeight,
        position: 'fixed',
        width: '100%',
        left: 0,
        top: 0,
        zIndex: 999,
        backgroundColor: '#fff'
    },
    avatar: {
        width: 40,
        height: 40,
        marginRight: 10
    },
    logoPro7: {
        width: 84,
        height: 60,
        marginRight: 30
    },
    leftWrapper: {
        flexDirection: 'row',
        alignItems: 'center'
    },
    logoWrapper: {
        width: 200
    }
})

export default MainHeader;