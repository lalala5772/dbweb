import boto3
import json

# AWS 리전 및 AWS IoT 엔드포인트 정보를 설정합니다.
region = 'AWS 리전'
iot_endpoint = 'AWS IoT 엔드포인트'

# AWS 서비스 클라이언트를 생성합니다.
iot_client = boto3.client('iot', region_name=region)
dynamodb_client = boto3.client('dynamodb', region_name=region)

# 새로운 규칙을 생성합니다.
def create_iot_rule(rule_name, sql, table_name):
    rule_payload = {
        'sql': sql,
        'actions': [
            {
                'dynamoDB': {
                    'tableName': table_name,
                    'roleArn': 'DynamoDB에 접근할 수 있는 역할의 ARN'
                }
            }
        ]
    }
    
    response = iot_client.create_topic_rule(
        ruleName=rule_name,
        topicRulePayload=rule_payload
    )
    
    print(f"규칙 '{rule_name}'이 생성되었습니다.")

# MQTT 메시지를 처리하는 콜백 함수
def process_message(message):
    payload = json.loads(message.payload.decode('utf-8'))
    print("수신한 메시지:", payload)
    
    # DynamoDB에 메시지 저장
    response = dynamodb_client.put_item(
        TableName='DynamoDB 테이블 이름',
        Item={
            'timestamp': {'N': str(payload['timestamp'])},
            'value': {'S': payload['value']}
        }
    )
    print("메시지가 DynamoDB에 저장되었습니다.")

# MQTT 클라이언트를 생성하고 연결합니다.
mqtt_client = boto3.client('iot-data', region_name=region, endpoint_url=iot_endpoint)

# MQTT 메시지를 구독하기 위한 토픽을 설정합니다.
mqtt_topic = '구독할 MQTT 토픽'

# MQTT 메시지를 수신하기 위한 콜백 함수를 등록합니다.
mqtt_client.subscribe(
    topic=mqtt_topic,
    qos=1,
    callback=process_message
)

# AWS IoT Core Rule 생성
rule_name = 'my_rule'  # 규칙 이름 설정
sql = f"SELECT * FROM '{mqtt_topic}'"
table_name = 'DynamoDB 테이블 이름'

create_iot_rule(rule_name, sql, table_name)

# 메시지 수신을 지속적으로 처리하기 위해 무한 루프를 실행합니다.
while True:
    pass
