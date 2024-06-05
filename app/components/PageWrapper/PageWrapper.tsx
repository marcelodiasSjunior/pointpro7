import React from 'react';
import { View } from 'react-native';
import { styles } from './styles';

const PageWrapper = ({ children, noPadding = false }: { children: React.ReactNode, noPadding?: boolean }) => {
    return <View style={[{ paddingHorizontal: noPadding ? 0 : 14, paddingBottom: noPadding ? 0 : 14 }, styles.wrapper]}>{children}</View>;
}



export default PageWrapper;