#Configuration

#CQRS model

Actions в контроллере 
получение данных

        1. getAction(GET)

каждый метод работает со своим менеджером

        1. QueryManagerInterface

группы  сериализации

    1. api_get_header - получение заголовков

статусы:

    получение:
        заголовок(ки) найдены HTTP_OK 200
    ошибки:
        если заголовок не найден HeaderNotFoundException возвращает HTTP_NOT_FOUND 404
        если заголовок не прошел валидацию HeaderInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

