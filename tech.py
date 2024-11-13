import pygame
import time
import paho.mqtt.client as mqtt
 
msg_import = ""
def on_message(client, userdata, msg):
    global msg_import
    msg_import = msg.payload.decode()
 
#broker setup
 
broker_address = "192.168.123.132"  
broker_port = 1883  # Default port for MQTT
 
# Create a new MQTT client instance
client = mqtt.Client()
 
# Connect to the broker
client.connect(broker_address, broker_port)
time.sleep(1)
client.on_message = on_message
 
client.subscribe("TIL_R")
 
# Initialize Pygame
pygame.init()
 
pygame.display.set_caption('Garage Tilburg')
 
img_car = pygame.image.load("car.jpg")
img_car = pygame.transform.scale(img_car, (60, 60))
img_pcar = pygame.image.load("pcar.png")
img_pcar = pygame.transform.scale(img_pcar, (60, 60))
img_asfalt = pygame.image.load("asfalt.png")
img_asfalt = pygame.transform.scale(img_asfalt, (500, 500))
img_p = pygame.image.load("p.png")
img_p = pygame.transform.scale(img_p, (125, 125))
img_line = pygame.image.load("line.png")
 
# Set up the screen dimensions
screen_width = 1440
screen_height = 720
screen = pygame.display.set_mode((screen_width, screen_height))
 
# Colors
DARK_GREY = (50, 50, 50)
GREEN = (50, 128, 50)
GREY = (169, 169, 169)
RED = (255, 0, 0)
LEDRED = (128, 0, 0)
LEDGREEN = (0, 255, 0)
BLUE = (20, 20, 100)
WHITE = (255, 255, 255)
TEXTBOX = (0, 0, 255)
 
# Set up the clock
clock = pygame.time.Clock()
 
font = pygame.font.Font(None, 36)
text_width = 200
text_height = 40
text_rect = pygame.Rect(360, 540, text_width, text_height)
text_rect2 = pygame.Rect(360, 565, text_width, text_height)
 
# Square properties
garage_size = 500 # Increased to 600x600
wall_height = 175
wall_width = 10
car_size = 60
p_size = 125
 
# Create initial positions for the squares
garage_1 = ((screen_width / 2 - garage_size), 50)
garage_2 = ((screen_width / 2), 50)
wall_1 = (screen_width/2 - wall_width / 2, 50)
wall_2 = (screen_width/2 - wall_width / 2, 50 + garage_size - wall_height)
 
car_pos = [100, 700]
 
# Define movement speed for the red square
speed = 5
 
def check_collision(rect, obstacles):
    for obstacle in obstacles:
        if rect.colliderect(obstacle):
            return True
    return False
 
car_rect = pygame.Rect(car_pos[0], car_pos[1], car_size, car_size)
 
obj_list = []
 
wall_1_rect = pygame.Rect(wall_1[0], wall_1[1], wall_width, wall_height)
obj_list.append(wall_1_rect)
wall_2_rect = pygame.Rect(wall_2[0], wall_2[1], wall_width, wall_height)
obj_list.append(wall_2_rect)
garage_1_bottom_rect = pygame.Rect(garage_1[0], garage_1[1], garage_size * 2, 10)  # Bottom part of garage
obj_list.append(garage_1_bottom_rect)
garage_1_left_rect = pygame.Rect(garage_1[0], garage_1[1], 10, garage_size)  # Left side of garage
obj_list.append(garage_1_left_rect)
garage_1_right_rect = pygame.Rect(garage_1[0] + garage_size * 2, garage_1[1], 10, garage_size)  # Right side of garage
obj_list.append(garage_1_right_rect)
garage_1_top_rect = pygame.Rect(garage_1[0] + 150, garage_1[1] + garage_size - 10, garage_size * 2 - 150, 10)  # Top part of garage
obj_list.append(garage_1_top_rect)
 
class Parkeerplaats:
    def __init__(self, space, x, y, decoy):
        self.space = space
        self.x = x
        self.y = y
        self.free = '1'
        if 3 < self.space <= 6 or self.space > 8:
            self.loc = 'low'
        else:
            self.loc = 'high'
       
        self.p_rect = pygame.Rect(x, y, p_size, p_size)
        self.decoy = decoy
       
        if self.decoy:
            self.dec = pygame.Rect(self.x + p_size/4, self.y + p_size/4, p_size / 2, p_size / 2)
        else:
            self.dec = pygame.Rect(-100, -100, 1, 1)
 
    def draw(self):
        # pygame.draw.rect(screen, BLUE, (self.x, self.y, p_size, p_size))
        screen.blit(img_line, (self.x, self.y))
        screen.blit(img_line, (self.x + 115, self.y))
        text = f"P{self.space}"
        text_surface = font.render(text, True, (255, 255, 255))
 
        if self.free == '1':
            color = LEDGREEN
        else:
            color = LEDRED
        if self.loc == 'high':
            i = -10
            j = p_size + 10
        else:
            i = p_size + 10
            j = -36
        pygame.draw.rect(screen, color, (self.x, self.y + i, p_size, 5))
        screen.blit(text_surface, (self.x + 50, self.y + j))
        # pygame.draw.rect(screen, RED, self.dec)
        screen.blit(img_pcar, self.dec)
 
    def taken(self):
        if check_collision(self.p_rect, [car_rect, self.dec]):
            self.free = '0'
        else:
            self.free = '1'
 
p_list = []
 
p1 = Parkeerplaats(1, 265, 100, True)
p2 = Parkeerplaats(2, p1.x + p_size + 20, 100, True)
p3 = Parkeerplaats(3, p2.x + p_size + 20, 100, False)
p4 = Parkeerplaats(4, p1.x + p_size + 20, 380, False)
p5 = Parkeerplaats(5, p2.x + p_size + 20, 380, True)
p6 = Parkeerplaats(1, p3.x + p_size + 85, 100, True)
p7 = Parkeerplaats(2, p6.x + p_size + 20, 100, False)
p8 = Parkeerplaats(3, p7.x + p_size + 20, 100, True)
p9 = Parkeerplaats(4, p5.x + p_size + 85, 380, True)
p10 = Parkeerplaats(5, p9.x + p_size + 20, 380, True)
p11 = Parkeerplaats(6, p10.x + p_size + 20, 380, False)
 
p_list.append(p1)
p_list.append(p2)
p_list.append(p3)
p_list.append(p4)
p_list.append(p5)
p_list.append(p6)
p_list.append(p7)
p_list.append(p8)
p_list.append(p9)
p_list.append(p10)
p_list.append(p11)
 
p1_list = []
p2_list = []
 
for p in p_list[0:5]:
    p1_list.append(p)
for p in p_list[5:]:
    p2_list.append(p)
 
car_list = []
car_list.append(car_rect)
 
sens_1 = pygame.Rect(220, 540, garage_1_bottom_rect.width - garage_1_top_rect.width, 10)
sens_2 = pygame.Rect(wall_1[0], wall_1[1] + wall_height, 10, 500 - wall_height*2)
 
sens_1_cur = False
sens_2_cur = False
sens_1_prev = False
sens_2_prev = False
inMain = False
outMain = False
fr1to2 = False
fr2to1 = False
 
reservation = ""
 
client.loop_start()
x = 0
y = 0
# Game loop
running = True
time = 1
while running:
    screen.fill(GREEN)
    pygame.draw.rect(screen, GREY, (garage_1[0], garage_1[1], garage_size, garage_size))
    screen.blit(img_asfalt, garage_1)
    pygame.draw.rect(screen, GREY, (garage_2[0], garage_2[1], garage_size, garage_size))
    screen.blit(img_asfalt, garage_2)
   
    prev_x = car_rect.x
    prev_y = car_rect.y
 
    # Check for events
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False  
 
    # Move the red squared
    keys = pygame.key.get_pressed()
    if keys[pygame.K_a]:  # Left
        car_rect.x -= speed
        if check_collision(car_rect, obj_list):
            car_rect.x += speed
 
    if keys[pygame.K_d]:  # Right
        car_rect.x += speed
        if check_collision(car_rect, obj_list):
            car_rect.x -= speed
 
    if keys[pygame.K_w]:  # Up
        car_rect.y -= speed
        if check_collision(car_rect, obj_list):
            car_rect.y += speed
 
    if keys[pygame.K_s]:  # Down
        car_rect.y += speed
        if check_collision(car_rect, obj_list):
            car_rect.y -= speed
 
    for p in p_list:
        p.taken()
        p.draw()
 
    sens_1_prev = sens_1_cur
    sens_1_cur = check_collision(sens_1, car_list)
    if sens_1_cur == False and sens_1_prev == True:
        if car_rect.y < prev_y:
            inMain = True      
            print('inMain: ', inMain)      
        if car_rect.y > prev_y:
            outMain = True
            print('outMain: ', outMain)
 
    sens_2_prev = sens_2_cur
    sens_2_cur = check_collision(sens_2, car_list)
    if sens_2_cur == False and sens_2_prev == True:
        if car_rect.x < prev_x:
            fr2to1 = True
            print('fr2to1: ', fr2to1)
        if car_rect.x > prev_x:
            fr1to2 = True
            print('fr1to2: ', fr1to2)
   
    # Make sure red square stays inside the screen bounds
    car_pos[0] = max(0, min(car_pos[0], screen_width - car_size))
    car_pos[1] = max(0, min(car_pos[1], screen_height - car_size))
 
    # Draw the red square
    # pygame.draw.rect(screen, RED, car_rect)
    screen.blit(img_car, car_rect)
    pygame.draw.rect(screen, DARK_GREY, wall_1_rect)
    pygame.draw.rect(screen, DARK_GREY, wall_2_rect)
    pygame.draw.rect(screen, DARK_GREY, garage_1_bottom_rect)
    pygame.draw.rect(screen, DARK_GREY, garage_1_left_rect)
    pygame.draw.rect(screen, DARK_GREY, garage_1_right_rect)
    pygame.draw.rect(screen, DARK_GREY, garage_1_top_rect)
    pygame.draw.rect(screen, WHITE, sens_1)
    pygame.draw.rect(screen, WHITE, sens_2)
   
 
    if time == 60:  
        topic = 'TIL_S'  
        msg = ""
        if inMain:
            msg+='1'
        else:
            msg+='0'
        if outMain:
            msg+='1'
        else:
            msg+='0'
        if fr1to2:
            msg+='1'
        else:
            msg+='0'
        if fr2to1:
            msg+='1'
        else:
            msg+='0'
        client.publish(topic, msg)
        print(topic, " = ", msg)
 
        topic = 'TIL_P1'
        msg = ""
        for p in p_list[0:5]:
            msg+= p.free
        client.publish(topic, msg)
        print(topic, " = ", msg)
 
        topic = 'TIL_P2'
        msg = ""
        for p in p_list[5:]:
            msg+= p.free
        client.publish(topic, msg)
        print(topic, " = ", msg)
 
        inMain = False
        outMain = False
        fr1to2 = False
        fr2to1 = False
 
 
 
        # client.loop()
        # if msg_import != reservation:
        #     reservation = msg_import
        #     print(reservation)
       
 
        x = 0
        for p in p1_list:
            if p.free == '1':
                x+=1
        y = 0
        for p in p2_list:  
            if p.free == '1':
                y+=1
 
        time = 0
 
    pygame.draw.rect(screen, TEXTBOX, text_rect)
    pygame.draw.rect(screen, TEXTBOX, text_rect2)
    text = "Verdieping 1: " + str(x) + " vrij"
    text2 = "Verdieping 2: " + str(y) + " vrij"
    text_surface = font.render(text, True, (255, 255, 255))
    text_surface2 = font.render(text2, True, (255, 255, 255))
    text_rect = text_surface.get_rect(center=text_rect.center)
    text_rect2 = text_surface2.get_rect(center=text_rect2.center)
    screen.blit(text_surface, text_rect)
    screen.blit(text_surface2, text_rect2)
 
    # Update the screen
    pygame.display.flip()    
    time += 1
 
    # Cap the frame rate
    clock.tick(60)
 
# Quit Pygame
pygame.quit()