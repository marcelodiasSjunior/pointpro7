import React, { useEffect } from 'react';
import { View, Text, StyleSheet } from 'react-native';
import PageWrapper from '../../../components/PageWrapper/PageWrapper';
import { FontAwesome5 } from '@expo/vector-icons';
import { useHomeStore } from '../../../store/home'
import CustomSpinner from '../../../components/CustomSpinner/CustomSpinner';
import Colors from '../../../constants/Colors';
import { useTranslation } from 'react-i18next';
import { TouchableOpacity } from 'react-native-gesture-handler';
import RoutePaths from '../../../constants/RoutePaths';
import { router } from 'expo-router';

const Home: React.FC = () => {
  const { home, loadHomeData, loading } = useHomeStore();
  const { t } = useTranslation();
  useEffect(() => {
    loadHomeData();
  }, [])

  const navigate = (path: string) => {
    router.push(path)
  }

  return (
    <PageWrapper>
      <CustomSpinner show={loading} />
      {
        home?.funcao && <View style={styles.grid}>
          <View style={styles.card}>
            <TouchableOpacity onPress={() => navigate(RoutePaths.atividades)}>
              <FontAwesome5 name="chart-line" size={40} color={Colors.primary} style={styles.icon} />
              <Text style={styles.counter}>{home?.atividades}</Text>
              <Text style={styles.text}>{t('atividades')}</Text>
            </TouchableOpacity>
          </View>

          <View style={styles.card}>
            <TouchableOpacity onPress={() => navigate(RoutePaths.observacoes)}>
              <FontAwesome5 name="comments" size={40} color={Colors.primary} style={styles.icon} />
              <Text style={styles.counter}>{home?.observacoes}</Text>
              <Text style={styles.text}>{t('observacoes')}</Text>
            </TouchableOpacity>
          </View>

          <View style={styles.card}>
            <TouchableOpacity onPress={() => navigate(RoutePaths.perfil)}>
              <FontAwesome5 name="briefcase" size={40} color={Colors.primary} style={styles.icon} />
              <Text style={styles.text}>{home?.funcao?.title}</Text>
            </TouchableOpacity>
          </View>

          <View style={styles.card}>
            <TouchableOpacity onPress={() => navigate(RoutePaths.perfil)}>
              <FontAwesome5 name="hourglass-start" size={40} color={Colors.primary} style={styles.icon} />
              <Text style={styles.text}>{home?.jornada?.total_semana} {t('horasSemanais')}</Text>
            </TouchableOpacity>
          </View>

          <View style={styles.card}>
            <TouchableOpacity onPress={() => navigate(RoutePaths.perfil)}>
              <FontAwesome5 name="building" size={40} color={Colors.primary} style={styles.icon} />
              <Text style={styles.text}>{home?.company?.title}</Text>
            </TouchableOpacity>
          </View>

          <View style={styles.card}>
            <TouchableOpacity onPress={() => { console.log('abrir arquivo de onboarding') }}>
              <FontAwesome5 name="toggle-on" size={40} color={Colors.primary} style={styles.icon} />
              <Text style={styles.text}>{t('onboarding')}</Text>
            </TouchableOpacity>
          </View>
        </View>
      }

    </PageWrapper >
  );
}

const styles = StyleSheet.create({
  grid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    paddingHorizontal: 6,
    justifyContent: 'space-between',
    marginTop: 10
  },
  card: {
    width: '48%',
    justifyContent: 'center',
    alignItems: 'center',
    paddingVertical: 30,
    paddingHorizontal: 10,
    borderWidth: 1,
    borderColor: Colors.primary,
    marginBottom: 20,
    borderRadius: 10,
    cursor: 'pointer'
  },
  text: {
    marginTop: 10,
    paddingHorizontal: 4,
    textAlign: 'center'
  },
  counter: {
    marginTop: 4,
    fontSize: 24,
    fontWeight: 'bold',
    color: Colors.primary,
    textAlign: 'center'
  },
  icon: {
    textAlign: 'center'
  }
})

export default Home;