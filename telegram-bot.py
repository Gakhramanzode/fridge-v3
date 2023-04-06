import telebot
from telebot import types
import mysql.connector
import datetime

users = {} # объявляем пустой словарь в глобальной области видимости

# Подключение к базе данных MySQL
db = mysql.connector.connect(
    host="host",
    user="user",
    password="password",
    database="database"
)
cursor = db.cursor()

# Токен бота Telegram
bot = telebot.TeleBot("token")

# Обработка команды /start
@bot.message_handler(commands=['start'])
def start(message):
    query = ""
    cursor.execute(query)
    members = cursor.fetchall()
    global users # используем глобальный словарь
    for member in members:
        users[member[3]] = member[0]
    chat_id = message.chat.id
    bot.send_message(message.chat.id, '', parse_mode= 'Markdown')

# Обработка команды /mylist
@bot.message_handler(commands=['mylist'])
def mylist(message):
    query = ""
    cursor.execute(query)
    members = cursor.fetchall()
    global users
    for member in members:
        users[member[3]] = member[0]
    chat_id = message.chat.id
    if chat_id in users:
        username = users[chat_id]
        query = f""
        cursor.execute(query)
        products = cursor.fetchall()
        if not products:
            bot.send_message(chat_id, "У вас нет продуктов")
        else:
            text = "Ваши продукты:\n\n"
            for product in products:
                text += f"{product[1]} - до {product[3]}\n"
            bot.send_message(chat_id, text)
    else:
        bot.send_message(chat_id, "Вы не зарегистрированы в нашем сервисе")

# Обработка команды /add
@bot.message_handler(commands=['add'])
def add(message):
    global username
    chat_id = message.chat.id
    if chat_id in users:
        username = users[chat_id]
        bot.send_message(chat_id, "Введите название продукта")
        bot.register_next_step_handler(message, get_name)
    else:
        bot.send_message(chat_id, "Вы не зарегистрированы в нашем сервисе")

def get_name(message):
    global name
    name = message.text
    bot.send_message(message.chat.id, "Введите дату окончания срока годности продукта в формате ГГГГ-ММ-ДД")
    bot.register_next_step_handler(message, get_expiration_date)

def get_expiration_date(message):
    global expiration_date
    global username
    expiration_date = message.text
    try:
        query = f""
        cursor.execute(query)
        db.commit()
        bot.send_message(message.chat.id, "Продукт успешно добавлен")
    except Exception as e:
        bot.send_message(message.chat.id, "Произошла ошибка: " + str(e))

# Обработка команды /delete
@bot.message_handler(commands=['delete'])
def delete(message):
    chat_id = message.chat.id
    if chat_id in users:
        username = users[chat_id]
        query = f""
        cursor.execute(query)
        products = cursor.fetchall()
        if not products:
            bot.send_message(chat_id, "У вас нет продуктов")
        else:
            markup = types.InlineKeyboardMarkup()
            for product in products:
                button = types.InlineKeyboardButton(text=product[1], callback_data=f"delete_{product[0]}")
                markup.add(button)
            bot.send_message(chat_id, "Выберите продукт для удаления:", reply_markup=markup)
    else:
        bot.send_message(chat_id, "Вы не зарегистрированы в нашем сервисе")

@bot.callback_query_handler(func=lambda call: call.data.startswith("delete_"))
def callback_delete(call):
    chat_id = call.message.chat.id
    if chat_id in users:
        username = users[chat_id]
        product_id = call.data.split("_")[1]
        query = f""
        cursor.execute(query)
        db.commit()
        bot.answer_callback_query(call.id, "Продукт удален")
    else:
        bot.send_message(chat_id, "Вы не зарегистрированы в нашем сервисе")

# Обработка команды /myid
@bot.message_handler(commands=['myid'])
def ID(message):
  bot.send_message(message.chat.id,'Ваш ID: `{0.id}`'.format(message.from_user, bot.get_me()), 
                parse_mode= 'Markdown')

# Обработка команды /schedule
@bot.message_handler(commands=['schedule'])
def schedule(message):
    chat_id = message.chat.id
    if chat_id in users:
        msg = bot.send_message(chat_id, "Введите время напоминания в формате ЧЧ:ММ")
        bot.register_next_step_handler(msg, process_time_step)
    else:
        bot.send_message(chat_id, "Вы не зарегистрированы в нашем сервисе")

def process_time_step(message):
    chat_id = message.chat.id
    if chat_id in users:
        time = message.text
        try:
            datetime.datetime.strptime(time, '%H:%M')
            username = users[chat_id]
            query = f""
            cursor.execute(query)
            db.commit()
            bot.send_message(chat_id, "Время напоминания сохранено")
        except ValueError:
            msg = bot.send_message(chat_id, "Неверный формат времени. Пожалуйста, введите время в формате ЧЧ:ММ")
            bot.register_next_step_handler(msg, process_time_step)
    else:
        bot.send_message(chat_id, "Вы не зарегистрированы в нашем сервисе")

# Обработка команды /unschedule
@bot.message_handler(commands=['unschedule'])
def unschedule(message):
    chat_id = message.chat.id
    if chat_id in users:
        username = users[chat_id]
        query = f""
        cursor.execute(query)
        db.commit()
        bot.send_message(chat_id, "Напоминание отменено")
    else:
        bot.send_message(chat_id, "Вы не зарегистрированы в нашем сервисе")

# Обработка команды /info
@bot.message_handler(commands=['info'])
def start_message(message):
  keyboard = types.InlineKeyboardMarkup()  
  keyboard.add(types.InlineKeyboardButton('Перейти на сайт', url=''))
  bot.send_message(message.chat.id, 'Сайт сервиса 👇', reply_markup=keyboard)

# Запуск бота
bot.polling()
