# Credit Sample Laravel Rubix

이 프로젝트는 **Laravel** 프레임워크와 **Rubix ML**을 활용한 신용 승인 예측 예제입니다.  
도커(Docker)로 개발 환경을 구성하며, 입력 폼/예측 결과 화면과 REST API를 모두 제공합니다.

---

## 주요 기술 스택

- PHP 8.2+
- Laravel 12.x (백엔드, 뷰)
- Rubix ML 2.5 (머신러닝)
- Docker, Docker Compose

---

## 실행 방법

### 1. 도커로 개발 환경 실행

```bash
docker-compose up --build
```

- 서버가 `http://localhost:8000`에서 실행됩니다.

### 2. Rubix ML 등 추가 패키지 설치 (필요 시)

```bash
docker-compose exec laravel-app composer require rubix/ml
```

### 3. 모델 학습 (첫 실행 시 자동으로 수행됨)

- 첫 요청 시 자동으로 모델 학습 및 저장
- 이후 요청에서는 저장된 모델을 불러와 빠르게 예측

---

## 주요 기능

- **메인 화면**  
  - `/` 접속 시 나이, 소득, 대출금액 입력 폼 제공
  - 예측 결과(승인/미승인) 화면에 표시

- **REST API**  
  - `POST /api/predict`  
    - JSON 입력: `{ "age": 30, "income": 6000, "loan": 1200 }`
    - JSON 응답: `{ "result": "1" }` (`1`: 승인, `0`: 미승인)

- **커맨드라인(artisan) 커맨드**  
  - `php artisan sys:status` : 서버 상태 정보 출력

---

## 폴더 구조

```
credit_sample_laravel_rubix/
├── app/
│   ├── Http/Controllers/
│   │   └── CreditPredictController.php    # 예측 로직 및 폼 처리
│   └── Services/
│       ├── CreditModelTrainer.php         # 모델 학습/저장/로드
│       └── CreditPredictService.php       # 예측 서비스
├── Models/
│   └── credit_model.rbx                    # 학습된 Rubix ML 모델 파일
├── resources/views/
│   └── main.blade.php                     # 입력/결과 화면 뷰
├── routes/
│   ├── web.php                            # 폼/화면 라우트
│   ├── api.php                            # API 라우트
│   └── console.php                        # 커맨드라인 artisan 명령
├── docker-compose.yml                     # 도커 컴포즈 설정
├── Dockerfile                             # 도커 이미지 설정
└── README.md                              # 이 파일
```

---

## 예제 API 호출

**PowerShell**

```powershell
curl -Method POST -Headers @{"Content-Type"="application/json"} -Body '{"age":30,"income":6000,"loan":1200}' http://localhost:8000/api/predict
```

**크롬 콘솔**

```javascript
fetch('http://localhost:8000/api/predict', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ age: 30, income: 6000, loan: 1200 })
}).then(res => res.json()).then(console.log);
```

---

## 모델 학습 로직

- **데이터 생성**: 랜덤으로 3000개의 샘플 생성 (나이, 소득, 대출금액, 승인여부)
- **모델 구조**: MultilayerPerceptron (Dense + ReLU + BatchNorm + Dropout 레이어)
- **저장/로드**: Native Serializer + Filesystem Persister 사용
- **최적화**: Adam Optimizer, 100 epochs, batch size 256

---

## 참고

- [Laravel 공식 문서](https://laravel.com/docs)
- [Rubix ML 공식 문서](https://rubixml.com/)
- [Docker 공식 문서](https://docs.docker.com/)