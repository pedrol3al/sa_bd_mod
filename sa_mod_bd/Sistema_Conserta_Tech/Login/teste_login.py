from selenium import webdriver
from selenium.webdriver.common.by import By
import time

driver = webdriver.Chrome()

driver.get("http://localhost/Sistema_Concerta_Tech/Login/login.html")

email_input = driver.find_element(By.ID, "email")
email_input.send_keys("pedro@gmail.com")

senha_input = driver.find_element(By.ID, "senha")
senha_input.send_keys("30052008")

submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
# submit_button.click()

time.sleep(8)

driver.quit() 