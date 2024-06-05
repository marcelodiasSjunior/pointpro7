import React, { useEffect } from 'react';
import { StyleSheet, TouchableOpacity, View } from 'react-native';
import { Text } from '../Themed';
import { Ionicons } from '@expo/vector-icons';
import { router, usePathname } from 'expo-router';
import Colors from '../../constants/Colors';
import { TabItem, useTabMenuList } from '../../hooks/tabMenuList';
import Sizes from '../../constants/Sizes';

const BottomTabs: React.FC = () => {
    const pathName = usePathname();
    const tabMenuList = useTabMenuList();
    const iconSize = 25;


    const getBgColor = (path: string) => {
        if (path === pathName) {
            return 'grey'
        }
    }

    const isActivePath = (path: string) => {
        return pathName.startsWith(path)
    }

    const getActiveStyles = (path = '') => {
        if (isActivePath(path)) {
            return styles.iconActive
        }
        return styles.icon
    }

    const getActiveIconName = (path: string, iconName: string) => {
        return !isActivePath(path) ? iconName + '-outline' : iconName
    }

    const navigate = (path: string) => {
        router.replace(path)
    }

    if (!tabMenuList) {
        return <></>
    }
    return (
        <View style={styles.container}>
            {tabMenuList.map((tab: TabItem, index: number) => {
                return (
                    <TouchableOpacity key={String(Math.random() + index)} style={[styles.tab, { backgroundColor: getBgColor('/') }]} onPress={() => navigate(tab.path)}>
                        <Ionicons
                            name={getActiveIconName(tab.path, tab.icon)}
                            size={iconSize}
                            style={getActiveStyles(tab.path)}
                        />
                        <Text style={[styles.text, getActiveStyles(tab.path)]}>{tab.name}</Text>
                    </TouchableOpacity>
                )
            })}
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        paddingHorizontal: 4,
        borderTopWidth: 0.5,
        borderTopColor: '#ccc',
        position: 'fixed',
        bottom: 0,
        left: 0,
        width: '100%',
        zIndex: 999999,
        height: Sizes.footerHeight,
        backgroundColor: '#fff'
    },
    tab: {
        alignItems: 'center',
        flex: 1,
        paddingVertical: 8
    },
    text: {
        marginTop: 4,
        fontSize: 12,
        color: '#000'
    },
    icon: {

    },
    iconActive: {
        color: Colors.primary
    }
})

export default BottomTabs;