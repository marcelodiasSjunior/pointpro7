import React, { useEffect } from 'react';
import PageWrapper from '../../../components/PageWrapper/PageWrapper';
import CustomSpinner from '../../../components/CustomSpinner/CustomSpinner';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { router } from 'expo-router';
import RoutePaths from '../../../constants/RoutePaths';

const Perfil: React.FC = () => {
    useEffect(() => {
        AsyncStorage.clear();
        setTimeout(() => {
            router.replace(RoutePaths.login)
        }, 1500)
    }, [])
    return <PageWrapper><CustomSpinner show={true} /></PageWrapper>;
}

export default Perfil;