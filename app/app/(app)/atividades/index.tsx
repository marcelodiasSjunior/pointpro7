import React, { useEffect } from 'react';
import { Dimensions, StyleSheet, Text, View } from 'react-native';
import PageWrapper from '../../../components/PageWrapper/PageWrapper';
import { useAtividadesStore } from '../../../store/atividades';
import { useTranslation } from 'react-i18next';
import CustomSpinner from '../../../components/CustomSpinner/CustomSpinner';
import CustomButton from '../../../components/CustomButton';
import CustomCard from '../../../components/CustomCard/CustomCard';
import { FuncionarioAtividadesCreateService, FuncionarioAtividadesUpdateService } from '../../../services/funcionario/atividades';
const { width: winWidth } = Dimensions.get("window");

const Atividades: React.FC = () => {
  const { data, loading, loadData } = useAtividadesStore()
  const { t } = useTranslation()
  useEffect(() => {
    loadData()
  }, [])


  const createTask = (item) => {
    FuncionarioAtividadesCreateService(item.atividade_funcionario.id, item.atividade_funcionario.atividade_id).then((data) => {
      loadData();
    })
  }

  const updateTask = (item) => {
    FuncionarioAtividadesUpdateService(item.funcionario_atividade.id, item.atividade_funcionario.atividade_id).then((data) => {
      loadData();
    })
  }

  return (
    <PageWrapper>
      <CustomSpinner show={loading} />
      <View style={styles.wrapper}>
        {data?.atividades && data?.atividades?.map((item, index) => {
          return (
            <CustomCard key={String(Math.random() + index)} style={styles.card}>
              <Text style={styles.desc}>{item.description}</Text>


              {item.current_status === 'nao_iniciada' && (
                <>
                  <Text style={styles.statusNaoIniciada}>{t(item.current_status)}</Text>
                  <CustomButton title="Iniciar" onSubmit={() => createTask(item)} />
                </>
              )}
              {item.current_status === 'iniciada' && (
                <>
                  <Text style={styles.statusIniciada}>{t(item.current_status)}</Text>
                  <CustomButton title="Finalizar" onSubmit={() => updateTask(item)} />
                </>
              )}
              {item.current_status === 'completa' && (
                <>
                  <Text style={styles.statusCompleta}>{t(item.current_status)}</Text>
                </>
              )}
            </CustomCard>
          )
        })}
      </View>

    </PageWrapper>
  );
}

const styles = StyleSheet.create({
  wrapper: {
    padding: 7,
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'space-between'
  },
  card: {
    width: winWidth > 768 ? (winWidth / 3) - 100 : '100%',
  },
  statusNaoIniciada: {
    padding: 7,
    backgroundColor: 'gray',
    color: '#fff',
    borderRadius: 20,
    textAlign: 'center',
    fontWeight: 'bold'
  },
  statusIniciada: {
    padding: 7,
    backgroundColor: '#900C3F',
    color: '#fff',
    borderRadius: 20,
    textAlign: 'center',
    fontWeight: 'bold'
  },
  statusCompleta: {
    padding: 7,
    backgroundColor: 'green',
    color: '#fff',
    borderRadius: 20,
    textAlign: 'center',
    fontWeight: 'bold'
  },
  desc: {
    fontSize: 16,
    marginBottom: 20
  }
})


export default Atividades;