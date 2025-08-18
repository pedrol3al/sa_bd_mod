from selenium import webdriver
from selenium.webdriver.common.by import By
import time

driver = webdriver.Chrome()

driver.get("C:/Users/pedro.leal/Documents/GitHub/sa_bd_mod/Sistema_Concerta_Tech/Usuario/usuario.html")

id_produto_input = driver.find_element(By. ID, "id_produto")
id_produto_input.send_keys("1")

descricao_input = driver.find_element(By. ID, "descricao")
descricao_input.send_keys("Tela de celular")

marca_input = driver.find_element(By.ID, "marca")
marca_input.send_keys("Iphone")

quantidade_input = driver.find_element(By.ID, "quantidade")
quantidade_input.send_keys("10")

preco_input = driver.find_element(By.ID, "preco")
preco_input.send_keys("R$6.500,00")

submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
# submit_button.click()

time.sleep(8)

driver.quit()