import { View, Image, StyleSheet } from "react-native"
import { useForm } from "react-hook-form"
import PageWrapper from "../../components/PageWrapper/PageWrapper"
import FormInput from "../../components/FormInput"
import CustomButton from "../../components/CustomButton"
const logoImage = require('../../assets/images/logo-big.png');

import { useAuthStore } from '../../store/auth';
import { router } from "expo-router"
import CustomSpinner from "../../components/CustomSpinner/CustomSpinner"
import { useEffect } from "react"
import FormWrapper from "../../components/FormWrapper/FormWrapper"
import RoutePaths from "../../constants/RoutePaths"

const AuthLogin = () => {
  const { user, loading, login } = useAuthStore((state) => state)

  const {
    control,
    handleSubmit,
    formState: { errors },
  } = useForm({
    defaultValues: {
      password: "",
      email: ""
    },
  })
  const onSubmit = async (data: any) => {
    const payload = {
      ...data,
      manter_conectado: true
    }
    login(payload);
  }

  useEffect(() => {
    if (user?.id && loading === false) {
      router.replace(RoutePaths.root);
    }
  }, [user, loading])


  return (
    <>
      <PageWrapper>
        <FormWrapper style={styles.form}>
          <Image
            style={styles.logo}
            source={logoImage}
            resizeMode="contain"
          />
          <FormInput control={control} errors={errors} placeholder="E-mail" name="email" />
          <FormInput control={control} errors={errors} placeholder="Senha" name="password" />

          <CustomButton title="Entrar" onSubmit={handleSubmit(onSubmit)} />
        </FormWrapper>
      </PageWrapper>
      <CustomSpinner show={loading} />
    </>
  )
}

const styles = StyleSheet.create({
  logo: {
    width: '80%',
    height: 80,
    objectFit: 'contain',
    marginBottom: 30
  },
  form: {
    display: 'flex',
    flexDirection: 'column',
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    width: '80%',
    marginLeft: '10%'
  }
})

export default AuthLogin;