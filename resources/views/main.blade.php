<!-- filepath: resources/views/main.blade.php -->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>승인 예측 테스트</title>
</head>
<body>
    <h2>승인 예측 테스트</h2>
    <form method="post">
        @csrf
        <label>나이: <input type="number" name="age" required></label><br>
        <label>소득: <input type="number" name="income" required></label><br>
        <label>대출금액: <input type="number" name="loan" required></label><br>
        <button type="submit">예측하기</button>
    </form>
    @if(!is_null($result))
        <h2>예측 결과: {{ $result }}</h2>
    @endif
</body>
</html>