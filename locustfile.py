from locust import HttpUser, task, between
from bs4 import BeautifulSoup


class AdminUser(HttpUser):
    wait_time = between(2, 5)

    def on_start(self):
        response = self.client.get("/")

        soup = BeautifulSoup(response.text, "html.parser")
        token = soup.find("input", {"name": "_token"})

        if token:
            csrf = token["value"]

            self.client.post(
                "/login",
                data={
                    "_token": csrf,
                    "role": "admin",
                    "username": "admin1",
                    "password": "admin123"
                },
                allow_redirects=True
            )

    @task(5)
    def dashboard(self):
        self.client.get("/admin/dashboard")

    @task(3)
    def history(self):
        self.client.get("/admin/history")

    @task(2)
    def settings(self):
        self.client.get("/admin/settings")