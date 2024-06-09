import pymysql
from dotenv import dotenv_values
config = dotenv_values(".env")


class FaceSQL:
    def __init__(self):
        if ('DB_CERTIFICATE' in config):
            self.conn = pymysql.connect(
                host=config['DB_HOST'],
                user=config['DB_USER'],
                password=config['DB_PASSWORD'],
                db=config['DB_NAME'],
                port=int(config['DB_PORT']),
                charset=config['DB_CHARSET'],
                ssl_ca=config['DB_CERTIFICATE']
            )
        else:
            self.conn = pymysql.connect(
                host=config['DB_HOST'],
                user=config['DB_USER'],
                password=config['DB_PASSWORD'],
                db=config['DB_NAME'],
                port=int(config['DB_PORT']),
                charset=config['DB_CHARSET']
            )

    def processFaceData(self, sqlstr, args=()):
        cursor = self.conn.cursor()
        try:
            cursor.execute(sqlstr, args)
            self.conn.commit()
        except Exception as e:
            self.conn.rollback()
            print(e)
        finally:
            cursor.close()

    def saveFaceData(self, payload):
        self.processFaceData("insert into biometria_facials(created_at, updated_at, user_id, encodings, upload_id, company_id, deleted_at) values(%s,%s,%s,%s,%s,%s,%s)",
                             (payload['created_at'], payload['updated_at'], payload['user_id'], payload['encodings'], payload['upload_id'], payload['company_id'], None))

    def savePresencaData(self, payload):
        self.processFaceData("insert into frequencias(company_id, funcionario_id, direction, frequencia_id, ponto, created_at, updated_at) values(%s,%s,%s,%s,%s,%s,%s)",
                             (payload['company_id'],payload['funcionario_id'], payload['direction'], payload['frequencia_id'], payload['ponto'], payload['created_at'], payload['updated_at']))

    def execute_float_sqlstr(self, sqlstr):
        cursor = self.conn.cursor()

        results = []
        try:
            cursor.execute(sqlstr)
            results = cursor.fetchall()
        except Exception as e:
            self.conn.rollback()
            print(e)
        finally:
            cursor.close()
        return results

    def execute_find_one(self, query):
        cursor = self.conn.cursor()

        results = []

        try:
            cursor.execute(query)
            columns = cursor.description
            for value in cursor.fetchall():
                tmp = {}
                for (index, column) in enumerate(value):
                    tmp[columns[index][0]] = column
                results.append(tmp)

        except Exception as e:
            self.conn.rollback()
            print(e)
        finally:
            cursor.close()

        if (results):
            return results[0]
        return False
    
    def execute_find_all(self, query):
        cursor = self.conn.cursor()

        results = []

        try:
            cursor.execute(query)
            columns = cursor.description
            for value in cursor.fetchall():
                tmp = {}
                for (index, column) in enumerate(value):
                    tmp[columns[index][0]] = column
                results.append(tmp)

        except Exception as e:
            self.conn.rollback()
            print(e)
        finally:
            cursor.close()

        if (results):
            return results[0]
        return False

    def sreachFaceData(self, id):
        return self.execute_float_sqlstr("select * from biometria_facials where ID="+id)

    def getFaceByUserId(self, user_id):
        return self.execute_find_one("select * from biometria_facials where user_id="+str(user_id))

    def getUserById(self, user_id):
        return self.execute_find_one("select * from users where id="+str(user_id))

    def getFuncionarioByUserId(self, user_id):
        return self.execute_find_one("select * from funcionarios where user_id="+str(user_id))

    def getUploadById(self, id):
        return self.execute_find_one("select * from uploads where id="+str(id))

    def getUserByToken(self, token):
        return self.execute_find_one("select * from personal_access_tokens where token='"+token+"'")

    def getUploadById(self, upload_id):
        return self.execute_find_one("select * from uploads where id="+str(upload_id))

    def getFaceByEnconding(self, encoding):
        return self.execute_float_sqlstr("select * from biometria_facials where encoding="+str(encoding))

    def allFaceData(self):
        return self.execute_float_sqlstr("select * from biometria_facials")
