FROM maven:3.9-eclipse-temurin-17 AS build

WORKDIR /workspace

# Copiamos todo el proyecto para poder compilar con Maven.
COPY . .

RUN mvn clean package -DskipTests

FROM eclipse-temurin:17-jre

WORKDIR /app

COPY --from=build /workspace/target/*.jar app.jar

EXPOSE 8080

ENTRYPOINT ["java", "-jar", "/app/app.jar"]