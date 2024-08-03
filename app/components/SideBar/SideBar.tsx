import { router, usePathname } from 'expo-router';
import { Text, StyleSheet, View } from 'react-native';
import { TouchableOpacity } from 'react-native-gesture-handler';
import { useEffect } from 'react';
import Animated, { Easing, useAnimatedStyle, useSharedValue, withTiming } from 'react-native-reanimated';
import { sideBarStore } from '../../store/sideBar';
import { Ionicons } from '@expo/vector-icons';
import Colors from '../../constants/Colors';
import { useWindowWidth } from '../../hooks/useWindowWidth';
import { useIsMobile } from '../../hooks/useIsMobile';
import useMenuList, { MenuItem } from '../../hooks/useMenuList';
import Sizes from '../../constants/Sizes';

const MenuItems = ({ onClick }: { onClick: Function }) => {

    const pathName = usePathname();
    const menuList = useMenuList();
    const isActivePath = (path: string) => {
        return pathName.startsWith(path)
    }
    const getActiveStyles = (path = '') => {
        if (isActivePath(path)) {
            return styles.menuItemActive
        }
        return {}
    }

    const getActiveIconName = (path: string, iconName: string) => {
        return !isActivePath(path) ? iconName + '-outline' : iconName
    }

    return (
        <View style={styles.menuItems}>
            {
                menuList.map((menuItem: MenuItem, index: number) => {
                    return (
                        <TouchableOpacity key={String(Math.random() + index)} style={[styles.menuItem, getActiveStyles(menuItem.path)]} onPress={() => {
                            onClick && onClick(menuItem.path)
                        }}>
                            <Ionicons name={getActiveIconName(menuItem.path, menuItem.icon)} size={30} style={[getActiveStyles(menuItem.path)]} />
                            <Text style={[styles.menuText, getActiveStyles(menuItem.path)]}>{menuItem.name}</Text>
                        </TouchableOpacity>
                    )
                })
            }
        </View >
    )
}

const SideBar: React.FC = () => {
    const { window } = useWindowWidth();
    const isMobile = useIsMobile();
    const sideBarState = sideBarStore((state) => state.state)
    const toggleSideBar = sideBarStore((state) => state.toggle)

    const randomWidth = useSharedValue(-window.width);
    const boxWidth = useSharedValue(0);

    const randomWidthDesktop = useSharedValue(0);
    const boxWidthDesktop = useSharedValue(200);

    const config = {
        duration: 500,
        easing: Easing.bezier(0.5, 0.01, 0, 1),
    };

    const style = useAnimatedStyle(() => {
        return {
            left: withTiming(randomWidth.value, config),
            width: withTiming(boxWidth.value, config),
        };
    });

    const styleDesktop = useAnimatedStyle(() => {
        return {
            left: withTiming(randomWidthDesktop.value, config),
            width: withTiming(boxWidthDesktop.value, config),
        };
    });


    useEffect(() => {
        if (sideBarState.length) {
            handleToggleSideBar()
        }

    }, [sideBarState])

    const handleToggleSideBar = () => {
        if (boxWidth.value === 0) {
            randomWidth.value = 0;
            boxWidth.value = window.width;
            randomWidthDesktop.value = -200;
            boxWidthDesktop.value = 0;
        } else {
            randomWidth.value = -window.width
            boxWidth.value = 0;
            randomWidthDesktop.value = 0;
            boxWidthDesktop.value = 200;
        }
    }

    const handleMenuClick = (path: string) => {
        if (isMobile) {
            toggleSideBar()
        }
        router.push(path)
    }

    if (window.width < 768) {
        return (
            <Animated.View style={[styles.box, style]}>
                <View style={styles.container}>
                    <MenuItems toggleSideBar={toggleSideBar} onClick={handleMenuClick} />
                </View>
                <TouchableOpacity containerStyle={styles.close} onPress={toggleSideBar}></TouchableOpacity>
            </Animated.View>
        )
    }


    return (

        <Animated.View style={[styles.boxDesktop, styleDesktop]}>
            <View style={styles.container}>
                <MenuItems onClick={handleMenuClick} />
            </View>
            <TouchableOpacity containerStyle={styles.close} onPress={toggleSideBar}></TouchableOpacity>
        </Animated.View>
    )

}

const styles = StyleSheet.create({
    container: {
        width: 200,
        backgroundColor: '#fff',
        position: 'relative',
        zIndex: 99999,
        borderRightWidth: 0.5,
        borderRightColor: '#ccc',
    },
    menuItems: {
        backgroundColor: '#fff'
    },
    menuItem: {
        flexDirection: 'row',
        alignItems: 'center',
        paddingVertical: 14,
        paddingHorizontal: 18,
        borderBottomWidth: 0.5,
        borderBottomColor: '#ccc',
        cursor: 'pointer'
    },
    menuItemActive: {
        color: '#fff',
        backgroundColor: Colors.primary
    },
    menuText: {
        marginLeft: 10
    },
    box: {
        height: '100%',
        position: 'absolute',
        zIndex: 99999,
        flexDirection: 'row',
        paddingTop: Sizes.headerHeight
    },
    boxDesktop: {
        height: '100%',
        width: 200,
        flexDirection: 'row',
        zIndex: 99999,
        paddingTop: Sizes.headerHeight
    },
    close: {
        width: '100%',
        height: '100%',
        left: 0,
        top: 0,
        zIndex: 2,
        backgroundColor: '#000',
        opacity: 0.3,
        position: 'absolute'
    },
    logoPro7: {
        width: 200,
        height: 60,
        marginVertical: 30
    },
});

export default SideBar;