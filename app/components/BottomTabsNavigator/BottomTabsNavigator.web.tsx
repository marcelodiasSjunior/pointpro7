import React from 'react';
import { useWindowWidth } from '../../hooks/useWindowWidth';
import BottomTabs from './BottomTabs';

const BottomTabsNavigator: React.FC = () => {
    const { window } = useWindowWidth();

    if (window.width > 768) {
        return <></>;
    }

    return <BottomTabs />;

}


export default BottomTabsNavigator;